<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Utility;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AdminSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $facilities = explode(',', Utility::where('key', 'facilities')->value('value'));
        $types = explode(',', Utility::where('key', 'types')->value('value'));
        $decorations = explode(',', Utility::where('key', 'decorations')->value('value'));
        $usage = explode(',', Utility::where('key', 'usage')->value('value'));
        $districts = explode(',', Utility::where('key', 'district')->value('value'));
        return view('admin-search', compact('facilities', 'types', 'decorations', 'usage', 'districts'));
    }

    public function search(Request $request)
    {
        $info = $request->info;
        $district = $request->district;
        $types1 = $request->types1; 
        $facilities = $request->facilities;
        $types = $request->types;
        $decorations = $request->decorations;
        $usage = $request->usage;
        $options = $request->options;
        
        // dd($request->all());
        $search = Property::where(function ($query) use ($info) {
            $query->where('code', 'LIKE', "%{$info}%")
                ->orWhere('building', 'LIKE', "%{$info}%");
        })
        ->when($district !== 'All', function ($query) use ($district) {
            $query->where('district', $district);
        })
        ->when(is_array($types1) && count($types1), function ($query) use ($types1) {
            foreach ($types1 as $type) {
                $query->whereRaw("FIND_IN_SET(?, types)", [$type]);
            }
        })
        ->when(is_array($facilities) && count($facilities), function ($query) use ($facilities) {
            foreach ($facilities as $facility) {
                $query->whereRaw("FIND_IN_SET(?, facilities)", [$facility]);
            }
        })
        ->when(is_array($types) && count($types), function ($query) use ($types) {
            foreach ($types as $type) {
                $query->whereRaw("FIND_IN_SET(?, types)", [$type]);
            }
        })
        ->when(is_array($decorations) && count($decorations), function ($query) use ($decorations) {
            foreach ($decorations as $decoration) {
                $query->whereRaw("FIND_IN_SET(?, decorations)", [$decoration]);
            }
        })
        ->when(is_array($usage) && count($usage), function ($query) use ($usage) {
            foreach ($usage as $use) {
                $query->whereRaw("FIND_IN_SET(?, usage)", [$use]);
            }
        })
        ->when(is_array($options) && count($options), function ($query) use ($options) {
            foreach ($options as $option) {
                $query->whereJsonContains('others', $option);
            }
        })
        ->when(request('gross_from') && request('gross_to'), function ($query) {
            $query->whereBetween('gross_sf', [request('gross_from'), request('gross_to')]);
        })
        ->when(request('net_from') && request('net_to'), function ($query) {
            $query->whereBetween('net_sf', [request('net_from'), request('net_to')]);
        })
        ->when(request('selling_from') && request('selling_to'), function ($query) {
            $query->whereBetween('selling_price', [request('selling_from'), request('selling_to')]);
        })
        ->when(request('rental_from') && request('rental_to'), function ($query) {
            $query->whereBetween('rental_price', [request('rental_from'), request('rental_to')]);
        })
        ->with('photos')
        ->orderBy('created_at', 'desc')
        ->get();

        $resultCount = $search->count();

        return response()->json(['message' => 'Search completed!', 'data' => $search, 'count' => $resultCount]);
    }

    public function exportSelectedColumns(Request $request)
    {
        $columnMapping = [
            'code' => 'Code',
            'building' => '大廈',
            'street' => '街道',
            'district' => '地區',
            'floor' => '樓層',
            'flat' => '單位',
            'block' => '座數',
            'rental_price' => '業主叫租',
            'rental_g' => '呎租(建)',
            'rental_n' => '呎租(實)',
            'selling_price' => '售價',
            'selling_g' => '呎價(建)',
            'selling_n' => '呎價(實)',
            'gross_sf' => '建築面積',
            'net_sf' => '實用面積',
            'mgmf' => '管理費',
            'rate' => '差餉',
            'land' => '地租',
            'oths' => '其他',
            'image' => '圖片'
        ];

        $selectedColumns = $request->input('columns', []);
        $selectedIds = $request->input('properties', []);
        $columnsInDb = array_keys($columnMapping);
        $columnsToFetch = array_intersect($selectedColumns, $columnsInDb);

        // Ensure 'code' column is first
        if (in_array('code', $columnsToFetch)) {
            $columnsToFetch = array_merge(['code'], array_diff($columnsToFetch, ['code']));
        }

        // Filter by selected IDs
        $query = Property::query();
        if (!empty($selectedIds)) {
            $query->whereIn('building_id', $selectedIds);
        }

        $data = $query->select(array_diff($columnsToFetch, ['image']))->get();

        // Map the column names in the header to Chinese
        $header = array_map(fn($column) => $columnMapping[$column], $columnsToFetch);

        return Excel::download(new class($data, $header, $columnsToFetch) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithCustomStartCell, \Maatwebsite\Excel\Concerns\WithTitle {
            private $data;
            private $header;
            private $columnsToFetch;

            public function __construct($data, $header, $columnsToFetch)
            {
                $this->data = $data;
                $this->header = $header;
                $this->columnsToFetch = $columnsToFetch;
            }

            public function array(): array
            {
                $rows = $this->data->map(function ($item) {
                    $row = $item->toArray();

                    // Add hyperlink to the image page if image column is selected
                    if (in_array('image', $this->columnsToFetch)) {
                        $pageUrl = route('property.imgs.excel.page', ['code' => $item->code]);
                        $row['image'] = '=HYPERLINK("' . $pageUrl . '", "See Images")';
                    }

                    return $row;
                })->toArray();

                return array_merge([$this->header], $rows);
            }

            public function startCell(): string
            {
                return 'A10'; // Start from row 10
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                // Insert Image
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('assets/logos/Picture1.png'));
                $drawing->setHeight(150);
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($sheet);

                // Footer Style
                $highestColumn = $sheet->getHighestColumn();
                $footerRow = count($this->data) + 10 + 1; // Adjust for the starting row
                $sheet->mergeCells("A{$footerRow}:{$highestColumn}{$footerRow}");
                $sheet->setCellValue("A{$footerRow}", '聲明：有關此物業之介紹書，包括本物業之細則及平面圖僅供參考，本公司巳力求準確，但不擔保或保證他們完整性及正確，貴客戶應自行研究及了解方可作根據。 一切資料並不能構成出價根據或合約中的任何部分。');
                $sheet->getStyle("A{$footerRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Apply font style
                $sheet->getStyle("A1:{$highestColumn}{$footerRow}")
                    ->getFont()
                    ->setName('Calibri')
                    ->setSize(14);
            }

            public function title(): string
            {
                return 'boshinghk-retail';
            }
        }, 'boshinghk-retail.xlsx');
    }

    public function propertyImgsExcel($code)
    {
        $property = Property::where('code', $code)->with('photos')->first();

        return view('shared_pages.excel-photos',compact('property'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
