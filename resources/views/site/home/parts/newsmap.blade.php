<div class="mvp-main-blog-wrap left relative" style="background-color: #f2f2f2;">
    <section class="pageWraper">
        <section id="mapSection">
            <div id="FilterHolder">
                <input type="hidden" id="searchtype" name="searchtype" value="1"/>
                <input type="hidden" id="pageno" name="pageno" value="1"/>
                <input type="hidden" id="pagenocountry" name="pagenocountry" value="1"/>
                <input type="hidden" id="pagesize" name="pagesize" value="10"/>
                <input type="hidden" id="countryid" name="countryid" value="0"/>
                <div class="headersSection">
                    <div id="mostNewBtn" class="activeMapTab">{{trans('site.map.latest_news')}}</div>
                    <div class="wrapperSelect">
                        <select id="selectoption">
                            <option id="0">{{trans('site.map.world')}}</option>
                            <option id="1">{{trans('site.map.arab_world')}}</option>
                            <option id="2">{{trans('site.map.asia')}}</option>
                            <option id="3">{{trans('site.map.africa')}}</option>
                            <option id="4">{{trans('site.map.europe')}}</option>
                            <option id="5">{{trans('site.map.north_america')}}</option>
                            <option id="6">{{trans('site.map.australia')}}</option>
                            <option id="7">{{trans('site.map.south_america')}}</option>
                        </select>
                    </div>
                </div>
                <div id="mostNew">
                </div>
            </div>
            <div id="bigMapHolder">
                <div id="map-canvas" class="map-canvas"></div>
                <div class="mapInfo">
                    <ul>
                        <li><span class="circularDiv grayInfo"></span>{{trans('site.map.no_posts')}}</li>
                        <li><span class="circularDiv greenInfo"></span>{{trans('site.map.1_3_posts')}}</li>
                        <li><span class="circularDiv yelowInfo"></span>{{trans('site.map.4_9_posts')}}</li>
                        <li><span class="circularDiv blueInfo"></span>{{trans('site.map.10_15_posts')}}</li>
                        <li><span class="circularDiv redInfo"></span>{{trans('site.map.16_more_posts')}}</li>
                    </ul>
                </div>
            </div>
            <div class="mapStyle">
                {{trans('site.map.change_map_style')}}
                <div id="mapstyles0" class="activeMapDesign"></div>
                <div id="mapstyles1"></div>
                <div id="mapstyles2"></div>
                <div id="mapstyles3"></div>
            </div>
        </section>
    </section>
</div>
