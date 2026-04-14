<!DOCTYPE html>
<html>
<head>
<style>
    @page { 
        size: 210mm 165mm; 
        margin: 0; 
    }
    
    html, body { 
        margin: 0; padding: 0; 
        width: 210mm; height: 165mm;
        overflow: hidden; font-family: sans-serif;
    }

    .label-table {
        border-collapse: separate; 
        border-spacing: 2mm; 
        margin-top: 0.5mm;  
        margin-left: 3mm;   
        table-layout: fixed;
    }

    .label-td {
        width: 38mm;  
        height: 18mm; 
        padding: 0;
        vertical-align: middle;
        text-align: center;
        box-sizing: border-box;
    }

    .barcode-item {
        display: inline-block; 
        margin: 0 auto;
        width: fit-content;
    }

    .barcode-item > div {
        display: inline-block !important;
        float: none !important;
    }

    .empty { border: none !important; }
    
    .id { font-size: 6pt; color: #888; display: block; line-height: 1; }
    .name { font-size: 7pt; font-weight: bold; display: block; margin: 0; line-height: 1; }
    .price { font-size: 8pt; color: #d63384; font-weight: bold; display: block; line-height: 1; }
</style>
</head>
<body>
    <table class="label-table">
        @php $currentBox = 0; $itemIndex = 0; @endphp
        @for($row = 1; $row <= 8; $row++)
            <tr>
                @for($col = 1; $col <= 5; $col++)
                    @php $currentBox++; @endphp
                    <td class="label-td {{ $currentBox <= $skip ? 'empty' : '' }}">
                        @if($currentBox > $skip && isset($barang[$itemIndex]))
                            @php $item = $barang[$itemIndex]; @endphp
                            
                            <div class="barcode-item">
                                {!! $generator->getBarcode($item->id_barang, $generator::TYPE_CODE_128, 1, 15) !!}
                            </div>

                            <span class="id">{{ $item->id_barang }}</span>
                            <span class="name">{{ $item->nama }}</span>
                            <span class="price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            
                            @php $itemIndex++; @endphp
                        @endif
                    </td>
                @endfor
            </tr>
        @endfor
    </table>
</body>
</html>