@extends('site.layout.layout')
@section('css')
    <link href='assets/css/newsmap.css?ver=5.7' media='all' rel="stylesheet"/>
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC6Xu5RSDCwNEeR1o5LuqwWxt07CA4ly4&language=ar&sensor=false">
    </script>

@endsection

@section('js')
    <script src="assets/js/newsMap/newsMap.js"></script>
@endsection

@section('content')
    <section class="pageWraper">
        <section id="mapSection">
            <div id="FilterHolder">
                <input type="hidden" id="searchtype" name="searchtype" value="1"/>
                <input type="hidden" id="pageno" name="pageno" value="1"/>
                <input type="hidden" id="pagenocountry" name="pagenocountry" value="1"/>
                <input type="hidden" id="pagesize" name="pagesize" value="10"/>
                <input type="hidden" id="countryid" name="countryid" value="0"/>
                <div class="headersSection">
                    <div id="mostNewBtn" class="activeMapTab">أحدث الأخبار</div>
                    <div class="wrapperSelect">
                        <select id="selectoption">
                            <option id="0">العالم</option>
                            <option id="1">الوطن العربي</option>
                            <option id="2">آسيا</option>
                            <option id="3">إفريقيا</option>
                            <option id="4">أوروبا</option>
                            <option id="5">أمريكا الشمالية</option>
                            <option id="6">أستراليا</option>
                            <option id="7">أمريكا الجنوبية</option>
                        </select>
                    </div>
                    <div id="chooseWeek"></div>
                </div>

                <div id="mostNew">
                </div>
            </div>

            <div id="bigMapHolder">
                <div id="map-canvas" class="map-canvas"></div>
                <div class="mapInfo">
                    <ul>
                        <li><span class="circularDiv grayInfo"></span>لا يوجد أخبار</li>
                        <li><span class="circularDiv greenInfo"></span>١ - ٣ أخبار</li>
                        <li><span class="circularDiv yelowInfo"></span>٤ - ٩ خبر</li>
                        <li><span class="circularDiv blueInfo"></span>١٠ - ١٥ خبر</li>
                        <li><span class="circularDiv redInfo"></span>١٦ خبر فما فوق</li>
                    </ul>

                </div>
            </div>
            <div class="mapStyle">
                اختر شكل الخريطة
                <div id="mapstyles0" class="activeMapDesign"></div>
                <div id="mapstyles1"></div>
                <div id="mapstyles2"></div>
                <div id="mapstyles3"></div>
            </div>
        </section>
    </section>
@endsection
