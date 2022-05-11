<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{ URL::asset('/') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="cp/css/myprint.css" rel="stylesheet" type="text/css" media="all"/>
    <style type="text/css" media="print">
        @media print {
            thead {
                display: table-header-group;
            }
        }
    </style>
    <style>
        @page {
            header: html_myHTMLHeader1;
            footer: html_myFooter1;
        }
    </style>
</head>
<body>
<htmlpageheader name="myHTMLHeader1">
    <div class="header-report">
        <a href="/en" class="head-logo-report">
            <img src="cp/media/logos/logo-head.png" alt=""/>
        </a>
        <div class="clear"></div>
    </div>
</htmlpageheader>

<div class="content-page">
    <div class="pagetitle-rg">
        <h3>{{ $title }}</h3>
    </div>

    @if(isset($filter) && is_array($filter) && sizeof($filter))
        <div class="totalshow-area">
            <h2 class="titletop">Filter Information</h2>
            <div class="total-show-region">
                @foreach($filter as $key=>$item)
                    <div class="totalshow">
                        <div class="totalshow-rg">
                            <span class="span1">{{ $key }}:</span>
                            <span class="span2">{{ ucfirst((string)$item) }}</span>
                        </div>
                    </div><!-- totalshow -->
                @endforeach
                <div class="clear"></div>
            </div>
        </div><!-- totalshow area -->
    @endif

    @if(isset($generalInfo) && is_array($generalInfo) && sizeof($generalInfo))
        <div class="totalshow-area">
            <h2 class="titletop">General Information</h2>
            <div class="total-show-region">
                @foreach($generalInfo as $key=>$item)
                    <div class="totalshow">
                        <div class="totalshow-rg">
                            <span class="span1">{{ $key }}:</span>
                            <span class="span2">{{ ucfirst((string)$item) }}</span>
                        </div>
                    </div><!-- totalshow -->
                @endforeach
                <div class="clear"></div>
            </div>
        </div><!-- totalshow area -->
    @endif

    @if(in_array($exportType,["all","chart"]) && $img)
        <img src="uploads/charts/{{ $img }}" class="chart-img" alt="Chart Image"/>
    @endif

    @if(in_array($exportType,["all","table"]))
        <div class="tabular-region">
        <!--<h4 class="tabular-title">{{ $title }}</h4>-->
            @if(sizeof($result))
                <table class="table table-striped table-bordered table-hover table-checkable order-column">
                    <thead>
                    <tr>
                        @foreach($keys as $key)
                            <th>{{ $key }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($result as $item)
                        <tr class="odd gradeX">
                            @foreach(array_merge(array_flip(array_keys($keys)), (is_array($item))?$item:$item->toArray()) as $mykey=>$a)
                                @if(in_array($mykey,array_keys($keys)))
                                    <td>{{ $a }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <span class="no-result">No Data</span>
            @endif
        </div>
    @endif
</div><!-- content page -->

<htmlpagefooter name="myFooter1">
    <div class="footer-report">
        <table class="footer-table">
            <tbody>
            <tr>
                <td class="fttable-tdfirst">{DATE j-m-Y h:i:s A}</td>
                <td class="fttable-tdlast">{PAGENO}/{nbpg}</td>
            </tr>
            </tbody>
        </table>
    </div>
</htmlpagefooter>
</body>
</html>
