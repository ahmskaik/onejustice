<div class="tab-pane active reportcampaing-region" id="tab_1_1" role="tabpanel">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">
                            <span data-counter="counterup" data-value="{{ $summary["emails_sent"] }}">0</span>
                        </h3>
                        <small>TOTAL SENT EMAILS</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                            <span class="sr-only">100% progress</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> progress</div>
                        <div class="status-number"> 100%</div>
                    </div>
                </div>
            </div>
        </div><!-- col lg 3 -->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-red-haze">
                            <span data-counter="counterup" data-value="{{ $summary["opens"]['unique_opens'] }}">0</span>
                        </h3>
                        <small>OPENS NO.</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{ $summary["opens"]['unique_opens']/$summary["emails_sent"]*100 }}%;"
                              class="progress-bar progress-bar-success red-haze">
                            <span class="sr-only">{{ round($summary["opens"]['unique_opens']/$summary["emails_sent"]*100) }}
                                % open</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> open</div>
                        <div
                            class="status-number"> {{ round($summary["opens"]['unique_opens']/$summary["emails_sent"]*100) }}
                            %
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col lg 3 -->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-blue-sharp">
                            <span data-counter="counterup"
                                  data-value="{{ $summary["clicks"]['unique_clicks'] }}">0</span>
                        </h3>
                        <small>CLICKS NO.</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{ $summary["clicks"]['unique_clicks']/$summary["emails_sent"]*100 }}%;"
                              class="progress-bar progress-bar-success blue-sharp">
                            <span class="sr-only">{{ round($summary["clicks"]['unique_clicks']/$summary["emails_sent"]*100) }}
                                % clicks</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> clicks</div>
                        <div
                            class="status-number"> {{ round($summary["clicks"]['unique_clicks']/$summary["emails_sent"]*100) }}
                            %
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col lg 3 -->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-purple-soft">
                            <span data-counter="counterup"
                                  data-value="{{ $summary["bounces"]['hard_bounces']+$summary["bounces"]['soft_bounces'] }}">0</span>
                        </h3>
                        <small>BOUNCES</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span
                            style="width: {{ ($summary["bounces"]['hard_bounces']+$summary["bounces"]['soft_bounces'])/$summary["emails_sent"]*100 }}%;"
                            class="progress-bar progress-bar-success purple-soft">
                            <span class="sr-only">{{ round(($summary["bounces"]['hard_bounces']+$summary["bounces"]['soft_bounces'])/$summary["emails_sent"]*100) }}
                                % Clicks</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> Clicks</div>
                        <div
                            class="status-number"> {{ round(($summary["bounces"]['hard_bounces']+$summary["bounces"]['soft_bounces'])/$summary["emails_sent"]*100) }}
                            %
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- col lg 3 -->
    </div>
    <div class="row report-chart-region">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--mobile portlet">
                <div class="kt-portlet__head kt-portlet--head-sm">
                    <div class="kt-portlet__head-label">
                       <span class="kt-portlet__head-icon">
                            <i class="flaticon2-graph"></i>
                       </span>
                        <h3 class="kt-portlet__head-title">Summary</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="chart_summary" class="chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row report-chart-region">
        <div class="col-md-6 col-sm-6">
            <div class="kt-portlet kt-portlet--mobile portlet">
                <div class="kt-portlet__head kt-portlet--head-sm">
                    <div class="kt-portlet__head-label">
                       <span class="kt-portlet__head-icon">
                            <i class="flaticon2-graph"></i>
                       </span>
                        <h3 class="kt-portlet__head-title">Domain Performance</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="chart_bar_domainperformance" class="chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="kt-portlet kt-portlet--mobile portlet">
                <div class="kt-portlet__head kt-portlet--head-sm">
                    <div class="kt-portlet__head-label">
                       <span class="kt-portlet__head-icon">
                            <i class="flaticon2-graph"></i>
                       </span>
                        <h3 class="kt-portlet__head-title">Most Countries</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="chart_pie_mostcountries" class="chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($clicks["urls_clicked"]) && sizeof($clicks["urls_clicked"]))
        <div class="row report-chart-region">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--mobile portlet">
                    <div class="kt-portlet__head kt-portlet--head-sm">
                        <div class="kt-portlet__head-label">
                       <span class="kt-portlet__head-icon">
                            <i class="flaticon2-graph"></i>
                       </span>
                            <h3 class="kt-portlet__head-title">Link Clicks</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover table-smreport">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Link</th>
                                    <th>Clicks No.</th>
                                    <th>Clicks Percent</th>
                                    <th>Unique No.</th>
                                    <th>Unique Percent</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $counter = 1;?>
                                @foreach($clicks["urls_clicked"] as $item)
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>
                                            <span class="mytdurl popovers" data-container="body" data-trigger="hover"
                                                  data-placement="top"
                                                  data-content="{{ $item['url'] }}">{{ $item['url'] }}</span>
                                        </td>
                                        <td>{{ $item['total_clicks'] }}</td>
                                        <td>{{ round($item['click_percentage']*100,2) }}%</td>
                                        <td>{{ $item['unique_clicks'] }}</td>
                                        <td>{{ round($item['unique_click_percentage']*100,2) }}%</td>
                                    </tr>
                                    <?php ++$counter?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(sizeof($advice))
        <div class="row report-chart-region">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--mobile portlet">
                    <div class="kt-portlet__head kt-portlet--head-sm">
                        <div class="kt-portlet__head-label">
                       <span class="kt-portlet__head-icon">
                            <i class="flaticon2-graph"></i>
                       </span>
                            <h3 class="kt-portlet__head-title">Advice</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover table-smreport">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $counter = 1;?>
                                @foreach($advice['advice'] as $item)
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>{!! $item['message'] !!}</td>
                                        <td>{{ $item['type'] }}</td>
                                    </tr>
                                    <?php ++$counter?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
