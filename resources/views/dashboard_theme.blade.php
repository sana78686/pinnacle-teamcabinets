@extends('layouts.backend.master')

@section('content')
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-graph icon-gradient bg-ripe-malin"></i>
                                </div>
                                <div>CRM Dashboard
                                    <div class="page-title-subheading">Examples of just how powerful ArchitectUI
                                     really is!</div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <button type="button" data-toggle="tooltip" title=""
                                    data-placement="bottom" class="mr-3 btn-shadow btn btn-dark"
                                    data-original-title="Example Tooltip">
                                    <i class="fa fa-star"></i>
                                </button>
                                <div class="d-inline-block dropdown">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                        <span class="pr-2 btn-icon-wrapper opacity-7">
                                            <i class="fa fa-business-time fa-w-20"></i>
                                        </span>
                                        Buttons
                                    </button>
                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                        class="dropdown-menu dropdown-menu-right">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link">
                                                    <i class="nav-link-icon lnr-inbox"></i>
                                                    <span> Inbox</span>
                                                    <div class="ml-auto badge badge-pill badge-secondary">86</div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link">
                                                    <i class="nav-link-icon lnr-book"></i>
                                                    <span> Book</span>
                                                    <div class="ml-auto badge badge-pill badge-danger">5</div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link">
                                                    <i class="nav-link-icon lnr-picture"></i>
                                                    <span> Picture</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a disabled="" class="nav-link disabled">
                                                    <i class="nav-link-icon lnr-file-empty"></i>
                                                    <span> File Disabled</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link"
                                href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm.html">
                                <span>Variation 1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link active"
                                href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html">
                                <span>Variation 2</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tabs-animation">
                        <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-3 card widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total Orders</div>
                                                <div class="widget-subheading">Last year expenses</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-success">1896</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper">
                                            <div class="progress-bar-sm progress">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    aria-valuenow="71" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 71%;"></div>
                                            </div>
                                            <div class="progress-sub-label">
                                                <div class="sub-label-left">YoY Growth</div>
                                                <div class="sub-label-right">100%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-3 card widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Products Sold</div>
                                                <div class="widget-subheading">Revenue streams</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-warning">$3M</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper">
                                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 85%;"></div>
                                            </div>
                                            <div class="progress-sub-label">
                                                <div class="sub-label-left">Sales</div>
                                                <div class="sub-label-right">100%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="mb-3 card widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Followers</div>
                                                <div class="widget-subheading">People Interested</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-danger">45,9%</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper">
                                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    aria-valuenow="46" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 46%;"></div>
                                            </div>
                                            <div class="progress-sub-label">
                                                <div class="sub-label-left">Twitter Progress</div>
                                                <div class="sub-label-right">100%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
                                <div class="mb-3 card widget-content">
                                    <div class="widget-content-outer">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Income</div>
                                                <div class="widget-subheading">Expected totals</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-focus">$147</div>
                                            </div>
                                        </div>
                                        <div class="widget-progress-wrapper">
                                            <div class="progress-bar-sm progress-bar-animated-alt progress">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 54%;"></div>
                                            </div>
                                            <div class="progress-sub-label">
                                                <div class="sub-label-left">Expenses</div>
                                                <div class="sub-label-right">100%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-xl-6">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3 col-xl-6">
                                        <div
                                            class="mb-3 text-left card widget-chart widget-chart2 card-btm-border card-shadow-success border-success">
                                            <div class="widget-chat-wrapper-outer">
                                                <div class="pt-3 pb-1 pl-3 widget-chart-content">
                                                    <div class="widget-chart-flex">
                                                        <div class="widget-numbers">
                                                            <div class="widget-chart-flex">
                                                                <div class="fsize-4">
                                                                    <small class="opacity-5">$</small>
                                                                    <span>874</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h6 class="mb-0 widget-subheading opacity-5">sales last month</h6>
                                                </div>
                                                <div
                                                    class="pl-2 mt-3 mb-3 no-gutters widget-chart-wrapper he-auto row">
                                                    <div class="col-md-9">
                                                        <div id="dashboard-sparklines-1" style="min-height: 100px;">
                                                            <div id="apexchartsl2tymcac"
                                                                class="apexcharts-canvas apexchartsl2tymcac"
                                                                style="width: 141px; height: 100px;"><svg
                                                                    id="SvgjsSvg1365" width="141"
                                                                    height="100"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    version="1.1"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    xmlns:svgjs="http://svgjs.com/svgjs"
                                                                    class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                                                    transform="translate(0, 0)"
                                                                    style="background: transparent;">
                                                                    <g id="SvgjsG1367"
                                                                        class="apexcharts-inner apexcharts-graphical"
                                                                        transform="translate(0, 0)">
                                                                        <defs id="SvgjsDefs1366">
                                                                            <clippath id="gridRectMaskl2tymcac">
                                                                                <rect id="SvgjsRect1371"
                                                                                    width="144" height="103"
                                                                                    x="-1.5" y="-1.5" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <clippath id="gridRectMarkerMaskl2tymcac">
                                                                                <rect id="SvgjsRect1372"
                                                                                    width="149" height="108"
                                                                                    x="-4" y="-4" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                        </defs>
                                                                        <rect id="SvgjsRect1370" width="1"
                                                                            height="100" x="0" y="0"
                                                                            rx="0" ry="0"
                                                                            fill="#b1b9c4" opacity="1"
                                                                            stroke-width="0" stroke-dasharray="0"
                                                                            class="apexcharts-xcrosshairs"
                                                                            filter="none" fill-opacity="0.9">
                                                                        </rect>
                                                                        <g id="SvgjsG1379" class="apexcharts-xaxis"
                                                                            transform="translate(0, 0)">
                                                                            <g id="SvgjsG1380"
                                                                                class="apexcharts-xaxis-texts-g"
                                                                                transform="translate(0, 1.875)"></g>
                                                                        </g>
                                                                        <g id="SvgjsG1383" class="apexcharts-grid">
                                                                            <line id="SvgjsLine1385" x1="0"
                                                                                y1="100" x2="141"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                            <line id="SvgjsLine1384" x1="0"
                                                                                y1="1" x2="0"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                        </g>
                                                                        <g id="SvgjsG1374"
                                                                            class="apexcharts-line-series apexcharts-plot-series">
                                                                            <g id="SvgjsG1375"
                                                                                class="apexcharts-series series-1"
                                                                                data:longestSeries="true"
                                                                                rel="1" data:realIndex="0">
                                                                                <path id="apexcharts-line-0"
                                                                                    d="M 2.9375 64.02877697841726C 4.99375 64.02877697841726 6.75625 57.8622816032888 8.8125 57.8622816032888C 10.86875 57.8622816032888 12.63125 55.80678314491264 14.6875 55.80678314491264C 16.74375 55.80678314491264 18.50625 68.13977389516958 20.5625 68.13977389516958C 22.61875 68.13977389516958 24.38125 61.973278520041106 26.4375 61.973278520041106C 28.49375 61.973278520041106 30.25625 64.02877697841726 32.3125 64.02877697841726C 34.36875 64.02877697841726 36.13125 36.27954779033916 38.1875 36.27954779033916C 40.24375 36.27954779033916 42.00625 51.69578622816033 44.0625 51.69578622816033C 46.11875 51.69578622816033 47.88125 33.19630010277493 49.9375 33.19630010277493C 51.99375 33.19630010277493 53.75625 80.47276464542651 55.8125 80.47276464542651C 57.86875 80.47276464542651 59.63125 47.58478931140802 61.6875 47.58478931140802C 63.74375 47.58478931140802 65.50625 45.52929085303186 67.5625 45.52929085303186C 69.61875 45.52929085303186 71.38125 75.33401849948612 73.4375 75.33401849948612C 75.49375 75.33401849948612 77.25625 60.94552929085303 79.3125 60.94552929085303C 81.36875 60.94552929085303 83.13125 44.50154162384378 85.1875 44.50154162384378C 87.24375 44.50154162384378 89.00625 37.30729701952723 91.0625 37.30729701952723C 93.11875 37.30729701952723 94.88125 42.44604316546762 96.9375 42.44604316546762C 98.99375 42.44604316546762 100.75625 59.917780061664956 102.8125 59.917780061664956C 104.86875 59.917780061664956 106.63125 53.751284686536486 108.6875 53.751284686536486C 110.74375 53.751284686536486 112.50625 72.25077081192188 114.5625 72.25077081192188C 116.61875 72.25077081192188 118.38125 72.25077081192188 120.4375 72.25077081192188C 122.49375 72.25077081192188 124.25625 4.419321685508734 126.3125 4.419321685508734C 128.36875 4.419321685508734 130.13125 44.50154162384378 132.1875 44.50154162384378C 134.24375 44.50154162384378 136.00625 52.723535457348405 138.0625 52.723535457348405"
                                                                                    fill="none" fill-opacity="1"
                                                                                    stroke="rgba(58,196,125,0.85)"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="3"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-line"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMaskl2tymcac)"
                                                                                    pathTo="M 2.9375 64.02877697841726C 4.99375 64.02877697841726 6.75625 57.8622816032888 8.8125 57.8622816032888C 10.86875 57.8622816032888 12.63125 55.80678314491264 14.6875 55.80678314491264C 16.74375 55.80678314491264 18.50625 68.13977389516958 20.5625 68.13977389516958C 22.61875 68.13977389516958 24.38125 61.973278520041106 26.4375 61.973278520041106C 28.49375 61.973278520041106 30.25625 64.02877697841726 32.3125 64.02877697841726C 34.36875 64.02877697841726 36.13125 36.27954779033916 38.1875 36.27954779033916C 40.24375 36.27954779033916 42.00625 51.69578622816033 44.0625 51.69578622816033C 46.11875 51.69578622816033 47.88125 33.19630010277493 49.9375 33.19630010277493C 51.99375 33.19630010277493 53.75625 80.47276464542651 55.8125 80.47276464542651C 57.86875 80.47276464542651 59.63125 47.58478931140802 61.6875 47.58478931140802C 63.74375 47.58478931140802 65.50625 45.52929085303186 67.5625 45.52929085303186C 69.61875 45.52929085303186 71.38125 75.33401849948612 73.4375 75.33401849948612C 75.49375 75.33401849948612 77.25625 60.94552929085303 79.3125 60.94552929085303C 81.36875 60.94552929085303 83.13125 44.50154162384378 85.1875 44.50154162384378C 87.24375 44.50154162384378 89.00625 37.30729701952723 91.0625 37.30729701952723C 93.11875 37.30729701952723 94.88125 42.44604316546762 96.9375 42.44604316546762C 98.99375 42.44604316546762 100.75625 59.917780061664956 102.8125 59.917780061664956C 104.86875 59.917780061664956 106.63125 53.751284686536486 108.6875 53.751284686536486C 110.74375 53.751284686536486 112.50625 72.25077081192188 114.5625 72.25077081192188C 116.61875 72.25077081192188 118.38125 72.25077081192188 120.4375 72.25077081192188C 122.49375 72.25077081192188 124.25625 4.419321685508734 126.3125 4.419321685508734C 128.36875 4.419321685508734 130.13125 44.50154162384378 132.1875 44.50154162384378C 134.24375 44.50154162384378 136.00625 52.723535457348405 138.0625 52.723535457348405"
                                                                                    pathFrom="M -1 100L -1 100L 8.8125 100L 14.6875 100L 20.5625 100L 26.4375 100L 32.3125 100L 38.1875 100L 44.0625 100L 49.9375 100L 55.8125 100L 61.6875 100L 67.5625 100L 73.4375 100L 79.3125 100L 85.1875 100L 91.0625 100L 96.9375 100L 102.8125 100L 108.6875 100L 114.5625 100L 120.4375 100L 126.3125 100L 132.1875 100L 138.0625 100">
                                                                                </path>
                                                                                <g id="SvgjsG1376"
                                                                                    class="apexcharts-series-markers-wrap">
                                                                                    <g
                                                                                        class="apexcharts-series-markers">
                                                                                        <circle id="SvgjsCircle1391"
                                                                                            r="0" cx="0"
                                                                                            cy="0"
                                                                                            class="apexcharts-marker wlboth9ucg no-pointer-events"
                                                                                            stroke="#ffffff"
                                                                                            fill="#3ac47d"
                                                                                            fill-opacity="1"
                                                                                            stroke-width="2"
                                                                                            stroke-opacity="0.9"
                                                                                            default-marker-size="0">
                                                                                        </circle>
                                                                                    </g>
                                                                                </g>
                                                                                <g id="SvgjsG1377"
                                                                                    class="apexcharts-datalabels"></g>
                                                                            </g>
                                                                        </g>
                                                                        <line id="SvgjsLine1386" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke="#b6b6b6"
                                                                            stroke-dasharray="0" stroke-width="1"
                                                                            class="apexcharts-ycrosshairs"></line>
                                                                        <line id="SvgjsLine1387" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke-dasharray="0"
                                                                            stroke-width="0"
                                                                            class="apexcharts-ycrosshairs-hidden">
                                                                        </line>
                                                                        <g id="SvgjsG1388"
                                                                            class="apexcharts-yaxis-annotations"></g>
                                                                        <g id="SvgjsG1389"
                                                                            class="apexcharts-xaxis-annotations"></g>
                                                                        <g id="SvgjsG1390"
                                                                            class="apexcharts-point-annotations"></g>
                                                                    </g>
                                                                    <g id="SvgjsG1381" class="apexcharts-yaxis"
                                                                        rel="0"
                                                                        transform="translate(-35, 0)">
                                                                        <g id="SvgjsG1382"
                                                                            class="apexcharts-yaxis-texts-g"></g>
                                                                    </g>
                                                                </svg>
                                                                <div class="apexcharts-legend"></div>
                                                                <div class="apexcharts-tooltip light">
                                                                    <div class="apexcharts-tooltip-series-group"><span
                                                                            class="apexcharts-tooltip-marker"
                                                                            style="background-color: rgb(58, 196, 125);"></span>
                                                                        <div class="apexcharts-tooltip-text">
                                                                            <div class="apexcharts-tooltip-y-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-label"></span><span
                                                                                    class="apexcharts-tooltip-text-value"></span>
                                                                            </div>
                                                                            <div class="apexcharts-tooltip-z-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="resize-triggers">
                                                            <div class="expand-trigger">
                                                                <div style="width: 142px; height: 101px;"></div>
                                                            </div>
                                                            <div class="contract-trigger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-xl-6">
                                        <div
                                            class="mb-3 text-left card widget-chart widget-chart2 card-btm-border card-shadow-primary border-primary">
                                            <div class="widget-chat-wrapper-outer">
                                                <div class="pt-3 pb-1 pl-3 widget-chart-content">
                                                    <div class="widget-chart-flex">
                                                        <div class="widget-numbers">
                                                            <div class="widget-chart-flex">
                                                                <div class="fsize-4">
                                                                    <small class="opacity-5">$</small>
                                                                    <span>1283</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h6 class="mb-0 widget-subheading opacity-5">sales Income</h6>
                                                </div>
                                                <div
                                                    class="pl-2 mt-3 mb-3 no-gutters widget-chart-wrapper he-auto row">
                                                    <div class="col-md-9">
                                                        <div id="dashboard-sparklines-2" style="min-height: 100px;">
                                                            <div id="apexcharts5dmopdf9"
                                                                class="apexcharts-canvas apexcharts5dmopdf9"
                                                                style="width: 141px; height: 100px;"><svg
                                                                    id="SvgjsSvg1395" width="141"
                                                                    height="100"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    version="1.1"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    xmlns:svgjs="http://svgjs.com/svgjs"
                                                                    class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                                                    transform="translate(0, 0)"
                                                                    style="background: transparent;">
                                                                    <g id="SvgjsG1397"
                                                                        class="apexcharts-inner apexcharts-graphical"
                                                                        transform="translate(0, 0)">
                                                                        <defs id="SvgjsDefs1396">
                                                                            <clippath id="gridRectMask5dmopdf9">
                                                                                <rect id="SvgjsRect1401"
                                                                                    width="144" height="103"
                                                                                    x="-1.5" y="-1.5" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <clippath id="gridRectMarkerMask5dmopdf9">
                                                                                <rect id="SvgjsRect1402"
                                                                                    width="149" height="108"
                                                                                    x="-4" y="-4" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                        </defs>
                                                                        <rect id="SvgjsRect1400" width="1"
                                                                            height="100" x="0" y="0"
                                                                            rx="0" ry="0"
                                                                            fill="#b1b9c4" opacity="1"
                                                                            stroke-width="0" stroke-dasharray="0"
                                                                            class="apexcharts-xcrosshairs"
                                                                            filter="none" fill-opacity="0.9">
                                                                        </rect>
                                                                        <g id="SvgjsG1409" class="apexcharts-xaxis"
                                                                            transform="translate(0, 0)">
                                                                            <g id="SvgjsG1410"
                                                                                class="apexcharts-xaxis-texts-g"
                                                                                transform="translate(0, 1.875)"></g>
                                                                        </g>
                                                                        <g id="SvgjsG1413" class="apexcharts-grid">
                                                                            <line id="SvgjsLine1415" x1="0"
                                                                                y1="100" x2="141"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                            <line id="SvgjsLine1414" x1="0"
                                                                                y1="1" x2="0"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                        </g>
                                                                        <g id="SvgjsG1404"
                                                                            class="apexcharts-line-series apexcharts-plot-series">
                                                                            <g id="SvgjsG1405"
                                                                                class="apexcharts-series series-1"
                                                                                data:longestSeries="true"
                                                                                rel="1" data:realIndex="0">
                                                                                <path id="apexcharts-line-0"
                                                                                    d="M 2.9375 64.02877697841726C 4.99375 64.02877697841726 6.75625 47.58478931140802 8.8125 47.58478931140802C 10.86875 47.58478931140802 12.63125 42.44604316546762 14.6875 42.44604316546762C 16.74375 42.44604316546762 18.50625 36.27954779033916 20.5625 36.27954779033916C 22.61875 36.27954779033916 24.38125 72.25077081192188 26.4375 72.25077081192188C 28.49375 72.25077081192188 30.25625 4.419321685508734 32.3125 4.419321685508734C 34.36875 4.419321685508734 36.13125 80.47276464542651 38.1875 80.47276464542651C 40.24375 80.47276464542651 42.00625 55.80678314491264 44.0625 55.80678314491264C 46.11875 55.80678314491264 47.88125 52.723535457348405 49.9375 52.723535457348405C 51.99375 52.723535457348405 53.75625 68.13977389516958 55.8125 68.13977389516958C 57.86875 68.13977389516958 59.63125 45.52929085303186 61.6875 45.52929085303186C 63.74375 45.52929085303186 65.50625 60.94552929085303 67.5625 60.94552929085303C 69.61875 60.94552929085303 71.38125 44.50154162384378 73.4375 44.50154162384378C 75.49375 44.50154162384378 77.25625 72.25077081192188 79.3125 72.25077081192188C 81.36875 72.25077081192188 83.13125 57.8622816032888 85.1875 57.8622816032888C 87.24375 57.8622816032888 89.00625 64.02877697841726 91.0625 64.02877697841726C 93.11875 64.02877697841726 94.88125 61.973278520041106 96.9375 61.973278520041106C 98.99375 61.973278520041106 100.75625 33.19630010277493 102.8125 33.19630010277493C 104.86875 33.19630010277493 106.63125 53.751284686536486 108.6875 53.751284686536486C 110.74375 53.751284686536486 112.50625 59.917780061664956 114.5625 59.917780061664956C 116.61875 59.917780061664956 118.38125 44.50154162384378 120.4375 44.50154162384378C 122.49375 44.50154162384378 124.25625 51.69578622816033 126.3125 51.69578622816033C 128.36875 51.69578622816033 130.13125 37.30729701952723 132.1875 37.30729701952723C 134.24375 37.30729701952723 136.00625 75.33401849948612 138.0625 75.33401849948612"
                                                                                    fill="none" fill-opacity="1"
                                                                                    stroke="rgba(0,123,255,0.85)"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="3"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-line"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMask5dmopdf9)"
                                                                                    pathTo="M 2.9375 64.02877697841726C 4.99375 64.02877697841726 6.75625 47.58478931140802 8.8125 47.58478931140802C 10.86875 47.58478931140802 12.63125 42.44604316546762 14.6875 42.44604316546762C 16.74375 42.44604316546762 18.50625 36.27954779033916 20.5625 36.27954779033916C 22.61875 36.27954779033916 24.38125 72.25077081192188 26.4375 72.25077081192188C 28.49375 72.25077081192188 30.25625 4.419321685508734 32.3125 4.419321685508734C 34.36875 4.419321685508734 36.13125 80.47276464542651 38.1875 80.47276464542651C 40.24375 80.47276464542651 42.00625 55.80678314491264 44.0625 55.80678314491264C 46.11875 55.80678314491264 47.88125 52.723535457348405 49.9375 52.723535457348405C 51.99375 52.723535457348405 53.75625 68.13977389516958 55.8125 68.13977389516958C 57.86875 68.13977389516958 59.63125 45.52929085303186 61.6875 45.52929085303186C 63.74375 45.52929085303186 65.50625 60.94552929085303 67.5625 60.94552929085303C 69.61875 60.94552929085303 71.38125 44.50154162384378 73.4375 44.50154162384378C 75.49375 44.50154162384378 77.25625 72.25077081192188 79.3125 72.25077081192188C 81.36875 72.25077081192188 83.13125 57.8622816032888 85.1875 57.8622816032888C 87.24375 57.8622816032888 89.00625 64.02877697841726 91.0625 64.02877697841726C 93.11875 64.02877697841726 94.88125 61.973278520041106 96.9375 61.973278520041106C 98.99375 61.973278520041106 100.75625 33.19630010277493 102.8125 33.19630010277493C 104.86875 33.19630010277493 106.63125 53.751284686536486 108.6875 53.751284686536486C 110.74375 53.751284686536486 112.50625 59.917780061664956 114.5625 59.917780061664956C 116.61875 59.917780061664956 118.38125 44.50154162384378 120.4375 44.50154162384378C 122.49375 44.50154162384378 124.25625 51.69578622816033 126.3125 51.69578622816033C 128.36875 51.69578622816033 130.13125 37.30729701952723 132.1875 37.30729701952723C 134.24375 37.30729701952723 136.00625 75.33401849948612 138.0625 75.33401849948612"
                                                                                    pathFrom="M -1 100L -1 100L 8.8125 100L 14.6875 100L 20.5625 100L 26.4375 100L 32.3125 100L 38.1875 100L 44.0625 100L 49.9375 100L 55.8125 100L 61.6875 100L 67.5625 100L 73.4375 100L 79.3125 100L 85.1875 100L 91.0625 100L 96.9375 100L 102.8125 100L 108.6875 100L 114.5625 100L 120.4375 100L 126.3125 100L 132.1875 100L 138.0625 100">
                                                                                </path>
                                                                                <g id="SvgjsG1406"
                                                                                    class="apexcharts-series-markers-wrap">
                                                                                    <g
                                                                                        class="apexcharts-series-markers">
                                                                                        <circle id="SvgjsCircle1421"
                                                                                            r="0" cx="0"
                                                                                            cy="0"
                                                                                            class="apexcharts-marker w9dank1uyg no-pointer-events"
                                                                                            stroke="#ffffff"
                                                                                            fill="#007bff"
                                                                                            fill-opacity="1"
                                                                                            stroke-width="2"
                                                                                            stroke-opacity="0.9"
                                                                                            default-marker-size="0">
                                                                                        </circle>
                                                                                    </g>
                                                                                </g>
                                                                                <g id="SvgjsG1407"
                                                                                    class="apexcharts-datalabels"></g>
                                                                            </g>
                                                                        </g>
                                                                        <line id="SvgjsLine1416" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke="#b6b6b6"
                                                                            stroke-dasharray="0" stroke-width="1"
                                                                            class="apexcharts-ycrosshairs"></line>
                                                                        <line id="SvgjsLine1417" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke-dasharray="0"
                                                                            stroke-width="0"
                                                                            class="apexcharts-ycrosshairs-hidden">
                                                                        </line>
                                                                        <g id="SvgjsG1418"
                                                                            class="apexcharts-yaxis-annotations"></g>
                                                                        <g id="SvgjsG1419"
                                                                            class="apexcharts-xaxis-annotations"></g>
                                                                        <g id="SvgjsG1420"
                                                                            class="apexcharts-point-annotations"></g>
                                                                    </g>
                                                                    <g id="SvgjsG1411" class="apexcharts-yaxis"
                                                                        rel="0"
                                                                        transform="translate(-35, 0)">
                                                                        <g id="SvgjsG1412"
                                                                            class="apexcharts-yaxis-texts-g"></g>
                                                                    </g>
                                                                </svg>
                                                                <div class="apexcharts-legend"></div>
                                                                <div class="apexcharts-tooltip light">
                                                                    <div class="apexcharts-tooltip-series-group"><span
                                                                            class="apexcharts-tooltip-marker"
                                                                            style="background-color: rgb(0, 123, 255);"></span>
                                                                        <div class="apexcharts-tooltip-text">
                                                                            <div class="apexcharts-tooltip-y-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-label"></span><span
                                                                                    class="apexcharts-tooltip-text-value"></span>
                                                                            </div>
                                                                            <div class="apexcharts-tooltip-z-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="resize-triggers">
                                                            <div class="expand-trigger">
                                                                <div style="width: 142px; height: 101px;"></div>
                                                            </div>
                                                            <div class="contract-trigger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-xl-6">
                                        <div
                                            class="mb-3 text-left card widget-chart widget-chart2 card-btm-border card-shadow-warning border-warning">
                                            <div class="widget-chat-wrapper-outer">
                                                <div class="pt-3 pb-1 pl-3 widget-chart-content">
                                                    <div class="widget-chart-flex">
                                                        <div class="widget-numbers">
                                                            <div class="widget-chart-flex">
                                                                <div class="fsize-4">
                                                                    <small class="opacity-5">$</small>
                                                                    <span>1286</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h6 class="mb-0 widget-subheading opacity-5">last month sales</h6>
                                                </div>
                                                <div
                                                    class="pl-2 mt-3 mb-3 no-gutters widget-chart-wrapper he-auto row">
                                                    <div class="col-md-9">
                                                        <div id="dashboard-sparklines-3" style="min-height: 100px;">
                                                            <div id="apexcharts7jkdyw87"
                                                                class="apexcharts-canvas apexcharts7jkdyw87"
                                                                style="width: 141px; height: 100px;"><svg
                                                                    id="SvgjsSvg1425" width="141"
                                                                    height="100"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    version="1.1"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    xmlns:svgjs="http://svgjs.com/svgjs"
                                                                    class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                                                    transform="translate(0, 0)"
                                                                    style="background: transparent;">
                                                                    <g id="SvgjsG1427"
                                                                        class="apexcharts-inner apexcharts-graphical"
                                                                        transform="translate(0, 0)">
                                                                        <defs id="SvgjsDefs1426">
                                                                            <clippath id="gridRectMask7jkdyw87">
                                                                                <rect id="SvgjsRect1431"
                                                                                    width="144" height="103"
                                                                                    x="-1.5" y="-1.5" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <clippath id="gridRectMarkerMask7jkdyw87">
                                                                                <rect id="SvgjsRect1432"
                                                                                    width="149" height="108"
                                                                                    x="-4" y="-4" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                        </defs>
                                                                        <rect id="SvgjsRect1430" width="1"
                                                                            height="100" x="0" y="0"
                                                                            rx="0" ry="0"
                                                                            fill="#b1b9c4" opacity="1"
                                                                            stroke-width="0" stroke-dasharray="0"
                                                                            class="apexcharts-xcrosshairs"
                                                                            filter="none" fill-opacity="0.9">
                                                                        </rect>
                                                                        <g id="SvgjsG1439" class="apexcharts-xaxis"
                                                                            transform="translate(0, 0)">
                                                                            <g id="SvgjsG1440"
                                                                                class="apexcharts-xaxis-texts-g"
                                                                                transform="translate(0, 1.875)"></g>
                                                                        </g>
                                                                        <g id="SvgjsG1443" class="apexcharts-grid">
                                                                            <line id="SvgjsLine1445" x1="0"
                                                                                y1="100" x2="141"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                            <line id="SvgjsLine1444" x1="0"
                                                                                y1="1" x2="0"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                        </g>
                                                                        <g id="SvgjsG1434"
                                                                            class="apexcharts-line-series apexcharts-plot-series">
                                                                            <g id="SvgjsG1435"
                                                                                class="apexcharts-series series-1"
                                                                                data:longestSeries="true"
                                                                                rel="1" data:realIndex="0">
                                                                                <path id="apexcharts-line-0"
                                                                                    d="M 2.9375 61.973278520041106C 4.99375 61.973278520041106 6.75625 52.723535457348405 8.8125 52.723535457348405C 10.86875 52.723535457348405 12.63125 64.02877697841726 14.6875 64.02877697841726C 16.74375 64.02877697841726 18.50625 59.917780061664956 20.5625 59.917780061664956C 22.61875 59.917780061664956 24.38125 33.19630010277493 26.4375 33.19630010277493C 28.49375 33.19630010277493 30.25625 47.58478931140802 32.3125 47.58478931140802C 34.36875 47.58478931140802 36.13125 44.50154162384378 38.1875 44.50154162384378C 40.24375 44.50154162384378 42.00625 37.30729701952723 44.0625 37.30729701952723C 46.11875 37.30729701952723 47.88125 45.52929085303186 49.9375 45.52929085303186C 51.99375 45.52929085303186 53.75625 53.751284686536486 55.8125 53.751284686536486C 57.86875 53.751284686536486 59.63125 72.25077081192188 61.6875 72.25077081192188C 63.74375 72.25077081192188 65.50625 51.69578622816033 67.5625 51.69578622816033C 69.61875 51.69578622816033 71.38125 4.419321685508734 73.4375 4.419321685508734C 75.49375 4.419321685508734 77.25625 44.50154162384378 79.3125 44.50154162384378C 81.36875 44.50154162384378 83.13125 72.25077081192188 85.1875 72.25077081192188C 87.24375 72.25077081192188 89.00625 75.33401849948612 91.0625 75.33401849948612C 93.11875 75.33401849948612 94.88125 36.27954779033916 96.9375 36.27954779033916C 98.99375 36.27954779033916 100.75625 57.8622816032888 102.8125 57.8622816032888C 104.86875 57.8622816032888 106.63125 60.94552929085303 108.6875 60.94552929085303C 110.74375 60.94552929085303 112.50625 68.13977389516958 114.5625 68.13977389516958C 116.61875 68.13977389516958 118.38125 55.80678314491264 120.4375 55.80678314491264C 122.49375 55.80678314491264 124.25625 64.02877697841726 126.3125 64.02877697841726C 128.36875 64.02877697841726 130.13125 42.44604316546762 132.1875 42.44604316546762C 134.24375 42.44604316546762 136.00625 80.47276464542651 138.0625 80.47276464542651"
                                                                                    fill="none" fill-opacity="1"
                                                                                    stroke="rgba(247,185,36,0.85)"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="3"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-line"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMask7jkdyw87)"
                                                                                    pathTo="M 2.9375 61.973278520041106C 4.99375 61.973278520041106 6.75625 52.723535457348405 8.8125 52.723535457348405C 10.86875 52.723535457348405 12.63125 64.02877697841726 14.6875 64.02877697841726C 16.74375 64.02877697841726 18.50625 59.917780061664956 20.5625 59.917780061664956C 22.61875 59.917780061664956 24.38125 33.19630010277493 26.4375 33.19630010277493C 28.49375 33.19630010277493 30.25625 47.58478931140802 32.3125 47.58478931140802C 34.36875 47.58478931140802 36.13125 44.50154162384378 38.1875 44.50154162384378C 40.24375 44.50154162384378 42.00625 37.30729701952723 44.0625 37.30729701952723C 46.11875 37.30729701952723 47.88125 45.52929085303186 49.9375 45.52929085303186C 51.99375 45.52929085303186 53.75625 53.751284686536486 55.8125 53.751284686536486C 57.86875 53.751284686536486 59.63125 72.25077081192188 61.6875 72.25077081192188C 63.74375 72.25077081192188 65.50625 51.69578622816033 67.5625 51.69578622816033C 69.61875 51.69578622816033 71.38125 4.419321685508734 73.4375 4.419321685508734C 75.49375 4.419321685508734 77.25625 44.50154162384378 79.3125 44.50154162384378C 81.36875 44.50154162384378 83.13125 72.25077081192188 85.1875 72.25077081192188C 87.24375 72.25077081192188 89.00625 75.33401849948612 91.0625 75.33401849948612C 93.11875 75.33401849948612 94.88125 36.27954779033916 96.9375 36.27954779033916C 98.99375 36.27954779033916 100.75625 57.8622816032888 102.8125 57.8622816032888C 104.86875 57.8622816032888 106.63125 60.94552929085303 108.6875 60.94552929085303C 110.74375 60.94552929085303 112.50625 68.13977389516958 114.5625 68.13977389516958C 116.61875 68.13977389516958 118.38125 55.80678314491264 120.4375 55.80678314491264C 122.49375 55.80678314491264 124.25625 64.02877697841726 126.3125 64.02877697841726C 128.36875 64.02877697841726 130.13125 42.44604316546762 132.1875 42.44604316546762C 134.24375 42.44604316546762 136.00625 80.47276464542651 138.0625 80.47276464542651"
                                                                                    pathFrom="M -1 100L -1 100L 8.8125 100L 14.6875 100L 20.5625 100L 26.4375 100L 32.3125 100L 38.1875 100L 44.0625 100L 49.9375 100L 55.8125 100L 61.6875 100L 67.5625 100L 73.4375 100L 79.3125 100L 85.1875 100L 91.0625 100L 96.9375 100L 102.8125 100L 108.6875 100L 114.5625 100L 120.4375 100L 126.3125 100L 132.1875 100L 138.0625 100">
                                                                                </path>
                                                                                <g id="SvgjsG1436"
                                                                                    class="apexcharts-series-markers-wrap">
                                                                                    <g
                                                                                        class="apexcharts-series-markers">
                                                                                        <circle id="SvgjsCircle1451"
                                                                                            r="0" cx="0"
                                                                                            cy="0"
                                                                                            class="apexcharts-marker wenubb7u no-pointer-events"
                                                                                            stroke="#ffffff"
                                                                                            fill="#f7b924"
                                                                                            fill-opacity="1"
                                                                                            stroke-width="2"
                                                                                            stroke-opacity="0.9"
                                                                                            default-marker-size="0">
                                                                                        </circle>
                                                                                    </g>
                                                                                </g>
                                                                                <g id="SvgjsG1437"
                                                                                    class="apexcharts-datalabels"></g>
                                                                            </g>
                                                                        </g>
                                                                        <line id="SvgjsLine1446" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke="#b6b6b6"
                                                                            stroke-dasharray="0" stroke-width="1"
                                                                            class="apexcharts-ycrosshairs"></line>
                                                                        <line id="SvgjsLine1447" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke-dasharray="0"
                                                                            stroke-width="0"
                                                                            class="apexcharts-ycrosshairs-hidden">
                                                                        </line>
                                                                        <g id="SvgjsG1448"
                                                                            class="apexcharts-yaxis-annotations"></g>
                                                                        <g id="SvgjsG1449"
                                                                            class="apexcharts-xaxis-annotations"></g>
                                                                        <g id="SvgjsG1450"
                                                                            class="apexcharts-point-annotations"></g>
                                                                    </g>
                                                                    <g id="SvgjsG1441" class="apexcharts-yaxis"
                                                                        rel="0"
                                                                        transform="translate(-35, 0)">
                                                                        <g id="SvgjsG1442"
                                                                            class="apexcharts-yaxis-texts-g"></g>
                                                                    </g>
                                                                </svg>
                                                                <div class="apexcharts-legend"></div>
                                                                <div class="apexcharts-tooltip light">
                                                                    <div class="apexcharts-tooltip-series-group"><span
                                                                            class="apexcharts-tooltip-marker"
                                                                            style="background-color: rgb(247, 185, 36);"></span>
                                                                        <div class="apexcharts-tooltip-text">
                                                                            <div class="apexcharts-tooltip-y-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-label"></span><span
                                                                                    class="apexcharts-tooltip-text-value"></span>
                                                                            </div>
                                                                            <div class="apexcharts-tooltip-z-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="resize-triggers">
                                                            <div class="expand-trigger">
                                                                <div style="width: 142px; height: 101px;"></div>
                                                            </div>
                                                            <div class="contract-trigger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-xl-6">
                                        <div
                                            class="mb-3 text-left card widget-chart widget-chart2 card-btm-border card-shadow-danger border-danger">
                                            <div class="widget-chat-wrapper-outer">
                                                <div class="pt-3 pb-1 pl-3 widget-chart-content">
                                                    <div class="widget-chart-flex">
                                                        <div class="widget-numbers">
                                                            <div class="widget-chart-flex">
                                                                <div class="fsize-4">
                                                                    <small class="opacity-5">$</small>
                                                                    <span>564</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h6 class="mb-0 widget-subheading opacity-5">total revenue</h6>
                                                </div>
                                                <div
                                                    class="pl-2 mt-3 mb-3 no-gutters widget-chart-wrapper he-auto row">
                                                    <div class="col-md-9">
                                                        <div id="dashboard-sparklines-4" style="min-height: 100px;">
                                                            <div id="apexcharts8edmdpr8"
                                                                class="apexcharts-canvas apexcharts8edmdpr8"
                                                                style="width: 141px; height: 100px;"><svg
                                                                    id="SvgjsSvg1455" width="141"
                                                                    height="100"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    version="1.1"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    xmlns:svgjs="http://svgjs.com/svgjs"
                                                                    class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                                                    transform="translate(0, 0)"
                                                                    style="background: transparent;">
                                                                    <g id="SvgjsG1457"
                                                                        class="apexcharts-inner apexcharts-graphical"
                                                                        transform="translate(0, 0)">
                                                                        <defs id="SvgjsDefs1456">
                                                                            <clippath id="gridRectMask8edmdpr8">
                                                                                <rect id="SvgjsRect1461"
                                                                                    width="144" height="103"
                                                                                    x="-1.5" y="-1.5" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <clippath id="gridRectMarkerMask8edmdpr8">
                                                                                <rect id="SvgjsRect1462"
                                                                                    width="149" height="108"
                                                                                    x="-4" y="-4" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                        </defs>
                                                                        <rect id="SvgjsRect1460" width="1"
                                                                            height="100" x="0" y="0"
                                                                            rx="0" ry="0"
                                                                            fill="#b1b9c4" opacity="1"
                                                                            stroke-width="0" stroke-dasharray="0"
                                                                            class="apexcharts-xcrosshairs"
                                                                            filter="none" fill-opacity="0.9">
                                                                        </rect>
                                                                        <g id="SvgjsG1469" class="apexcharts-xaxis"
                                                                            transform="translate(0, 0)">
                                                                            <g id="SvgjsG1470"
                                                                                class="apexcharts-xaxis-texts-g"
                                                                                transform="translate(0, 1.875)"></g>
                                                                        </g>
                                                                        <g id="SvgjsG1473" class="apexcharts-grid">
                                                                            <line id="SvgjsLine1475" x1="0"
                                                                                y1="100" x2="141"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                            <line id="SvgjsLine1474" x1="0"
                                                                                y1="1" x2="0"
                                                                                y2="100" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                        </g>
                                                                        <g id="SvgjsG1464"
                                                                            class="apexcharts-line-series apexcharts-plot-series">
                                                                            <g id="SvgjsG1465"
                                                                                class="apexcharts-series series-1"
                                                                                data:longestSeries="true"
                                                                                rel="1" data:realIndex="0">
                                                                                <path id="apexcharts-line-0"
                                                                                    d="M 2.9375 57.8622816032888C 4.99375 57.8622816032888 6.75625 37.30729701952723 8.8125 37.30729701952723C 10.86875 37.30729701952723 12.63125 64.02877697841726 14.6875 64.02877697841726C 16.74375 64.02877697841726 18.50625 61.973278520041106 20.5625 61.973278520041106C 22.61875 61.973278520041106 24.38125 60.94552929085303 26.4375 60.94552929085303C 28.49375 60.94552929085303 30.25625 45.52929085303186 32.3125 45.52929085303186C 34.36875 45.52929085303186 36.13125 55.80678314491264 38.1875 55.80678314491264C 40.24375 55.80678314491264 42.00625 75.33401849948612 44.0625 75.33401849948612C 46.11875 75.33401849948612 47.88125 4.419321685508734 49.9375 4.419321685508734C 51.99375 4.419321685508734 53.75625 44.50154162384378 55.8125 44.50154162384378C 57.86875 44.50154162384378 59.63125 36.27954779033916 61.6875 36.27954779033916C 63.74375 36.27954779033916 65.50625 44.50154162384378 67.5625 44.50154162384378C 69.61875 44.50154162384378 71.38125 42.44604316546762 73.4375 42.44604316546762C 75.49375 42.44604316546762 77.25625 80.47276464542651 79.3125 80.47276464542651C 81.36875 80.47276464542651 83.13125 53.751284686536486 85.1875 53.751284686536486C 87.24375 53.751284686536486 89.00625 59.917780061664956 91.0625 59.917780061664956C 93.11875 59.917780061664956 94.88125 68.13977389516958 96.9375 68.13977389516958C 98.99375 68.13977389516958 100.75625 33.19630010277493 102.8125 33.19630010277493C 104.86875 33.19630010277493 106.63125 52.723535457348405 108.6875 52.723535457348405C 110.74375 52.723535457348405 112.50625 72.25077081192188 114.5625 72.25077081192188C 116.61875 72.25077081192188 118.38125 72.25077081192188 120.4375 72.25077081192188C 122.49375 72.25077081192188 124.25625 47.58478931140802 126.3125 47.58478931140802C 128.36875 47.58478931140802 130.13125 51.69578622816033 132.1875 51.69578622816033C 134.24375 51.69578622816033 136.00625 64.02877697841726 138.0625 64.02877697841726"
                                                                                    fill="none" fill-opacity="1"
                                                                                    stroke="rgba(217,37,80,0.85)"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="3"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-line"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMask8edmdpr8)"
                                                                                    pathTo="M 2.9375 57.8622816032888C 4.99375 57.8622816032888 6.75625 37.30729701952723 8.8125 37.30729701952723C 10.86875 37.30729701952723 12.63125 64.02877697841726 14.6875 64.02877697841726C 16.74375 64.02877697841726 18.50625 61.973278520041106 20.5625 61.973278520041106C 22.61875 61.973278520041106 24.38125 60.94552929085303 26.4375 60.94552929085303C 28.49375 60.94552929085303 30.25625 45.52929085303186 32.3125 45.52929085303186C 34.36875 45.52929085303186 36.13125 55.80678314491264 38.1875 55.80678314491264C 40.24375 55.80678314491264 42.00625 75.33401849948612 44.0625 75.33401849948612C 46.11875 75.33401849948612 47.88125 4.419321685508734 49.9375 4.419321685508734C 51.99375 4.419321685508734 53.75625 44.50154162384378 55.8125 44.50154162384378C 57.86875 44.50154162384378 59.63125 36.27954779033916 61.6875 36.27954779033916C 63.74375 36.27954779033916 65.50625 44.50154162384378 67.5625 44.50154162384378C 69.61875 44.50154162384378 71.38125 42.44604316546762 73.4375 42.44604316546762C 75.49375 42.44604316546762 77.25625 80.47276464542651 79.3125 80.47276464542651C 81.36875 80.47276464542651 83.13125 53.751284686536486 85.1875 53.751284686536486C 87.24375 53.751284686536486 89.00625 59.917780061664956 91.0625 59.917780061664956C 93.11875 59.917780061664956 94.88125 68.13977389516958 96.9375 68.13977389516958C 98.99375 68.13977389516958 100.75625 33.19630010277493 102.8125 33.19630010277493C 104.86875 33.19630010277493 106.63125 52.723535457348405 108.6875 52.723535457348405C 110.74375 52.723535457348405 112.50625 72.25077081192188 114.5625 72.25077081192188C 116.61875 72.25077081192188 118.38125 72.25077081192188 120.4375 72.25077081192188C 122.49375 72.25077081192188 124.25625 47.58478931140802 126.3125 47.58478931140802C 128.36875 47.58478931140802 130.13125 51.69578622816033 132.1875 51.69578622816033C 134.24375 51.69578622816033 136.00625 64.02877697841726 138.0625 64.02877697841726"
                                                                                    pathFrom="M -1 100L -1 100L 8.8125 100L 14.6875 100L 20.5625 100L 26.4375 100L 32.3125 100L 38.1875 100L 44.0625 100L 49.9375 100L 55.8125 100L 61.6875 100L 67.5625 100L 73.4375 100L 79.3125 100L 85.1875 100L 91.0625 100L 96.9375 100L 102.8125 100L 108.6875 100L 114.5625 100L 120.4375 100L 126.3125 100L 132.1875 100L 138.0625 100">
                                                                                </path>
                                                                                <g id="SvgjsG1466"
                                                                                    class="apexcharts-series-markers-wrap">
                                                                                    <g
                                                                                        class="apexcharts-series-markers">
                                                                                        <circle id="SvgjsCircle1481"
                                                                                            r="0" cx="0"
                                                                                            cy="0"
                                                                                            class="apexcharts-marker wu4xxopu no-pointer-events"
                                                                                            stroke="#ffffff"
                                                                                            fill="#d92550"
                                                                                            fill-opacity="1"
                                                                                            stroke-width="2"
                                                                                            stroke-opacity="0.9"
                                                                                            default-marker-size="0">
                                                                                        </circle>
                                                                                    </g>
                                                                                </g>
                                                                                <g id="SvgjsG1467"
                                                                                    class="apexcharts-datalabels"></g>
                                                                            </g>
                                                                        </g>
                                                                        <line id="SvgjsLine1476" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke="#b6b6b6"
                                                                            stroke-dasharray="0" stroke-width="1"
                                                                            class="apexcharts-ycrosshairs"></line>
                                                                        <line id="SvgjsLine1477" x1="0"
                                                                            y1="0" x2="141"
                                                                            y2="0" stroke-dasharray="0"
                                                                            stroke-width="0"
                                                                            class="apexcharts-ycrosshairs-hidden">
                                                                        </line>
                                                                        <g id="SvgjsG1478"
                                                                            class="apexcharts-yaxis-annotations"></g>
                                                                        <g id="SvgjsG1479"
                                                                            class="apexcharts-xaxis-annotations"></g>
                                                                        <g id="SvgjsG1480"
                                                                            class="apexcharts-point-annotations"></g>
                                                                    </g>
                                                                    <g id="SvgjsG1471" class="apexcharts-yaxis"
                                                                        rel="0"
                                                                        transform="translate(-35, 0)">
                                                                        <g id="SvgjsG1472"
                                                                            class="apexcharts-yaxis-texts-g"></g>
                                                                    </g>
                                                                </svg>
                                                                <div class="apexcharts-legend"></div>
                                                                <div class="apexcharts-tooltip light">
                                                                    <div class="apexcharts-tooltip-series-group"><span
                                                                            class="apexcharts-tooltip-marker"
                                                                            style="background-color: rgb(217, 37, 80);"></span>
                                                                        <div class="apexcharts-tooltip-text">
                                                                            <div class="apexcharts-tooltip-y-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-label"></span><span
                                                                                    class="apexcharts-tooltip-text-value"></span>
                                                                            </div>
                                                                            <div class="apexcharts-tooltip-z-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="resize-triggers">
                                                            <div class="expand-trigger">
                                                                <div style="width: 142px; height: 101px;"></div>
                                                            </div>
                                                            <div class="contract-trigger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title">
                                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                                            Bandwidth Reports
                                        </div>
                                        <div class="btn-actions-pane-right text-capitalize">
                                            <button
                                                class="btn-wide btn-outline-2x btn btn-outline-primary btn-sm">View
                                                All</button>
                                        </div>
                                    </div>
                                    <div class="pt-2 pb-0 card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mt-2 widget-content">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="pr-2 widget-content-left fsize-1">
                                                                <div class="widget-numbers fsize-3 text-alternate">61%
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right w-100">
                                                                <div class="progress-bar-xs progress">
                                                                    <div class="progress-bar bg-alternate"
                                                                        role="progressbar" aria-valuenow="71"
                                                                        aria-valuemin="0" aria-valuemax="100"
                                                                        style="width: 71%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left fsize-1">
                                                            <div class="text-muted opacity-6">Server Target</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mt-2 widget-content">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="pr-2 widget-content-left fsize-1">
                                                                <div class="widget-numbers fsize-3 text-danger">71%
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right w-100">
                                                                <div class="progress-bar-xs progress">
                                                                    <div class="progress-bar bg-danger"
                                                                        role="progressbar" aria-valuenow="71"
                                                                        aria-valuemin="0" aria-valuemax="100"
                                                                        style="width: 71%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left fsize-1">
                                                            <div class="text-muted opacity-6">Income Target</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-0 widget-chart">
                                        <div id="dashboard-sparklines-primary" style="min-height: 279px;">
                                            <div id="apexcharts5hdmgyll"
                                                class="apexcharts-canvas apexcharts5hdmgyll"
                                                style="width: 488px; height: 265px;"><svg id="SvgjsSvg1484"
                                                    width="488" height="265"
                                                    xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                    xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                    style="background: transparent;">
                                                    <foreignobject x="0" y="0" width="488" height="265">
                                                        <div class="apexcharts-legend center position-bottom"
                                                            xmlns="http://www.w3.org/1999/xhtml"
                                                            style="inset: auto 0px 10px; position: absolute;">
                                                            <div class="apexcharts-legend-series" rel="1"
                                                                data:collapsed="false" style="margin: 0px 5px;">
                                                                <span class="apexcharts-legend-marker"
                                                                    rel="1" data:collapsed="false"
                                                                    style="background: rgb(0, 123, 255); color: rgb(0, 123, 255); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                                                    class="apexcharts-legend-text" rel="1"
                                                                    data:collapsed="false"
                                                                    style="color: rgb(55, 61, 63); font-family: Helvetica, Arial, sans-serif;">Marine</span>
                                                            </div>
                                                            <div class="apexcharts-legend-series" rel="2"
                                                                data:collapsed="false" style="margin: 0px 5px;">
                                                                <span class="apexcharts-legend-marker"
                                                                    rel="2" data:collapsed="false"
                                                                    style="background: rgb(22, 170, 255); color: rgb(22, 170, 255); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-radius: 2px;"></span><span
                                                                    class="apexcharts-legend-text" rel="2"
                                                                    data:collapsed="false"
                                                                    style="color: rgb(55, 61, 63); font-family: Helvetica, Arial, sans-serif;">Striking</span>
                                                            </div>
                                                        </div>
                                                        <style type="text/css">
                                                            .apexcharts-legend {
                                                                display: flex;
                                                                overflow: auto;
                                                                padding: 0 10px;
                                                            }

                                                            .apexcharts-legend.position-bottom,
                                                            .apexcharts-legend.position-top {
                                                                flex-wrap: wrap
                                                            }

                                                            .apexcharts-legend.position-right,
                                                            .apexcharts-legend.position-left {
                                                                flex-direction: column;
                                                                bottom: 0;
                                                            }

                                                            .apexcharts-legend.position-bottom.left,
                                                            .apexcharts-legend.position-top.left,
                                                            .apexcharts-legend.position-right,
                                                            .apexcharts-legend.position-left {
                                                                justify-content: flex-start;
                                                            }

                                                            .apexcharts-legend.position-bottom.center,
                                                            .apexcharts-legend.position-top.center {
                                                                justify-content: center;
                                                            }

                                                            .apexcharts-legend.position-bottom.right,
                                                            .apexcharts-legend.position-top.right {
                                                                justify-content: flex-end;
                                                            }

                                                            .apexcharts-legend-series {
                                                                cursor: pointer;
                                                            }

                                                            .apexcharts-legend.position-bottom .apexcharts-legend-series,
                                                            .apexcharts-legend.position-top .apexcharts-legend-series {
                                                                display: flex;
                                                                align-items: center;
                                                            }

                                                            .apexcharts-legend-text {
                                                                position: relative;
                                                                font-size: 14px;
                                                            }

                                                            .apexcharts-legend-marker {
                                                                position: relative;
                                                                display: inline-block;
                                                                cursor: pointer;
                                                                margin-right: 3px;
                                                            }

                                                            .apexcharts-legend.right .apexcharts-legend-series,
                                                            .apexcharts-legend.left .apexcharts-legend-series {
                                                                display: inline-block;
                                                            }

                                                            .apexcharts-legend-series.no-click {
                                                                cursor: auto;
                                                            }

                                                            .apexcharts-legend .apexcharts-hidden-zero-series {
                                                                display: none !important;
                                                            }

                                                            .inactive-legend {
                                                                opacity: 0.45;
                                                            }
                                                        </style>
                                                    </foreignobject>
                                                    <g id="SvgjsG1486" class="apexcharts-inner apexcharts-graphical"
                                                        transform="translate(47.25, 40)">
                                                        <defs id="SvgjsDefs1485">
                                                            <lineargradient id="SvgjsLinearGradient1489"
                                                                x1="0" y1="0" x2="0"
                                                                y2="1">
                                                                <stop id="SvgjsStop1490" stop-opacity="0.4"
                                                                    stop-color="rgba(216,227,240,0.4)"
                                                                    offset="0"></stop>
                                                                <stop id="SvgjsStop1491" stop-opacity="0.5"
                                                                    stop-color="rgba(190,209,230,0.5)"
                                                                    offset="1"></stop>
                                                                <stop id="SvgjsStop1492" stop-opacity="0.5"
                                                                    stop-color="rgba(190,209,230,0.5)"
                                                                    offset="1"></stop>
                                                            </lineargradient>
                                                            <clippath id="gridRectMask5hdmgyll">
                                                                <rect id="SvgjsRect1494" width="430.75"
                                                                    height="161.348" x="0" y="0" rx="0"
                                                                    ry="0" fill="#ffffff" opacity="1"
                                                                    stroke-width="0" stroke="none"
                                                                    stroke-dasharray="0"></rect>
                                                            </clippath>
                                                            <clippath id="gridRectMarkerMask5hdmgyll">
                                                                <rect id="SvgjsRect1495" width="438.75"
                                                                    height="169.348" x="-4" y="-4" rx="0"
                                                                    ry="0" fill="#ffffff" opacity="1"
                                                                    stroke-width="0" stroke="none"
                                                                    stroke-dasharray="0"></rect>
                                                            </clippath>
                                                        </defs>
                                                        <rect id="SvgjsRect1493" width="25.127083333333335"
                                                            height="161.348" x="35.20835978190104" y="0"
                                                            rx="0" ry="0"
                                                            fill="url(#SvgjsLinearGradient1489)" opacity="1"
                                                            stroke-width="0" stroke-dasharray="0"
                                                            class="apexcharts-xcrosshairs" filter="none"
                                                            fill-opacity="0.9"></rect>
                                                        <g id="SvgjsG1526" class="apexcharts-xaxis"
                                                            transform="translate(0, 0)">
                                                            <g id="SvgjsG1527" class="apexcharts-xaxis-texts-g"
                                                                transform="translate(0, -4)"><text
                                                                    id="SvgjsText1528"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="35.895833333333336" y="190.348"
                                                                    text-anchor="middle" dominate-baseline="central"
                                                                    font-size="12px" fill="#373d3f"
                                                                    class="apexcharts-xaxis-label"
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan1529"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        1</tspan>
                                                                    <title>1</title>
                                                                </text><text id="SvgjsText1530"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="107.6875" y="190.348" text-anchor="middle"
                                                                    dominate-baseline="central" font-size="12px"
                                                                    fill="#373d3f" class="apexcharts-xaxis-label"
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan1531"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        2</tspan>
                                                                    <title>2</title>
                                                                </text><text id="SvgjsText1532"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="179.47916666666666" y="190.348"
                                                                    text-anchor="middle" dominate-baseline="central"
                                                                    font-size="12px" fill="#373d3f"
                                                                    class="apexcharts-xaxis-label"
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan1533"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        3</tspan>
                                                                    <title>3</title>
                                                                </text><text id="SvgjsText1534"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="251.27083333333334" y="190.348"
                                                                    text-anchor="middle" dominate-baseline="central"
                                                                    font-size="12px" fill="#373d3f"
                                                                    class="apexcharts-xaxis-label"
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan1535"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        4</tspan>
                                                                    <title>4</title>
                                                                </text><text id="SvgjsText1536"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="323.06250000000006" y="190.348"
                                                                    text-anchor="middle" dominate-baseline="central"
                                                                    font-size="12px" fill="#373d3f"
                                                                    class="apexcharts-xaxis-label"
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan1537"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        5</tspan>
                                                                    <title>5</title>
                                                                </text><text id="SvgjsText1538"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="394.85416666666674" y="190.348"
                                                                    text-anchor="middle" dominate-baseline="central"
                                                                    font-size="12px" fill="#373d3f"
                                                                    class="apexcharts-xaxis-label"
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan1539"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        6</tspan>
                                                                    <title>6</title>
                                                                </text></g>
                                                            <line id="SvgjsLine1540" x1="0" y1="162.348"
                                                                x2="430.75" y2="162.348" stroke="#78909c"
                                                                stroke-dasharray="0" stroke-width="1"></line>
                                                        </g>
                                                        <g id="SvgjsG1550" class="apexcharts-grid">
                                                            <line id="SvgjsLine1551" x1="71.79166666666667"
                                                                y1="162.348" x2="71.79166666666667"
                                                                y2="168.348" stroke="#78909c"
                                                                stroke-dasharray="0" class="apexcharts-xaxis-tick">
                                                            </line>
                                                            <line id="SvgjsLine1552" x1="143.58333333333334"
                                                                y1="162.348" x2="143.58333333333334"
                                                                y2="168.348" stroke="#78909c"
                                                                stroke-dasharray="0" class="apexcharts-xaxis-tick">
                                                            </line>
                                                            <line id="SvgjsLine1553" x1="215.375" y1="162.348"
                                                                x2="215.375" y2="168.348" stroke="#78909c"
                                                                stroke-dasharray="0" class="apexcharts-xaxis-tick">
                                                            </line>
                                                            <line id="SvgjsLine1554" x1="287.1666666666667"
                                                                y1="162.348" x2="287.1666666666667"
                                                                y2="168.348" stroke="#78909c"
                                                                stroke-dasharray="0" class="apexcharts-xaxis-tick">
                                                            </line>
                                                            <line id="SvgjsLine1555" x1="358.95833333333337"
                                                                y1="162.348" x2="358.95833333333337"
                                                                y2="168.348" stroke="#78909c"
                                                                stroke-dasharray="0" class="apexcharts-xaxis-tick">
                                                            </line>
                                                            <line id="SvgjsLine1556" x1="0" y1="0"
                                                                x2="430.75" y2="0" stroke="#e0e0e0"
                                                                stroke-dasharray="0" class="apexcharts-gridline">
                                                            </line>
                                                            <line id="SvgjsLine1557" x1="0"
                                                                y1="26.891333333333336" x2="430.75"
                                                                y2="26.891333333333336" stroke="#e0e0e0"
                                                                stroke-dasharray="0" class="apexcharts-gridline">
                                                            </line>
                                                            <line id="SvgjsLine1558" x1="0"
                                                                y1="53.78266666666667" x2="430.75"
                                                                y2="53.78266666666667" stroke="#e0e0e0"
                                                                stroke-dasharray="0" class="apexcharts-gridline">
                                                            </line>
                                                            <line id="SvgjsLine1559" x1="0" y1="80.674"
                                                                x2="430.75" y2="80.674" stroke="#e0e0e0"
                                                                stroke-dasharray="0" class="apexcharts-gridline">
                                                            </line>
                                                            <line id="SvgjsLine1560" x1="0"
                                                                y1="107.56533333333334" x2="430.75"
                                                                y2="107.56533333333334" stroke="#e0e0e0"
                                                                stroke-dasharray="0" class="apexcharts-gridline">
                                                            </line>
                                                            <line id="SvgjsLine1561" x1="0"
                                                                y1="134.45666666666668" x2="430.75"
                                                                y2="134.45666666666668" stroke="#e0e0e0"
                                                                stroke-dasharray="0" class="apexcharts-gridline">
                                                            </line>
                                                            <line id="SvgjsLine1562" x1="0" y1="161.348"
                                                                x2="430.75" y2="161.348" stroke="#e0e0e0"
                                                                stroke-dasharray="0" class="apexcharts-gridline">
                                                            </line>
                                                            <line id="SvgjsLine1564" x1="0" y1="161.348"
                                                                x2="430.75" y2="161.348" stroke="transparent"
                                                                stroke-dasharray="0"></line>
                                                            <line id="SvgjsLine1563" x1="0" y1="1"
                                                                x2="0" y2="161.348" stroke="transparent"
                                                                stroke-dasharray="0"></line>
                                                        </g>
                                                        <g id="SvgjsG1497"
                                                            class="apexcharts-bar-series apexcharts-plot-series"
                                                            clip-path="url(#gridRectMask5hdmgyll)">
                                                            <g id="SvgjsG1498" class="apexcharts-series Marine"
                                                                rel="1" data:realIndex="0">
                                                                <path id="apexcharts-bar-area-0"
                                                                    d="M 10.76875 161.348L 10.76875 43.026133333333334L 35.895833333333336 43.026133333333334L 35.895833333333336 161.348L 10.76875 161.348"
                                                                    fill="rgba(0,123,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="0"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 10.76875 161.348L 10.76875 43.026133333333334L 35.895833333333336 43.026133333333334L 35.895833333333336 161.348L 10.76875 161.348"
                                                                    pathFrom="M 10.76875 161.348L 10.76875 161.348L 35.895833333333336 161.348L 35.895833333333336 161.348L 10.76875 161.348"
                                                                    cy="43.026133333333334" cx="82.56041666666667"
                                                                    j="0" val="44"
                                                                    barWidth="25.127083333333335"></path>
                                                                <path id="apexcharts-bar-area-0"
                                                                    d="M 82.56041666666667 161.348L 82.56041666666667 13.445666666666654L 107.6875 13.445666666666654L 107.6875 161.348L 82.56041666666667 161.348"
                                                                    fill="rgba(0,123,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="0"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 82.56041666666667 161.348L 82.56041666666667 13.445666666666654L 107.6875 13.445666666666654L 107.6875 161.348L 82.56041666666667 161.348"
                                                                    pathFrom="M 82.56041666666667 161.348L 82.56041666666667 161.348L 107.6875 161.348L 107.6875 161.348L 82.56041666666667 161.348"
                                                                    cy="13.445666666666654" cx="154.35208333333333"
                                                                    j="1" val="55"
                                                                    barWidth="25.127083333333335"></path>
                                                                <path id="apexcharts-bar-area-0"
                                                                    d="M 154.35208333333333 161.348L 154.35208333333333 51.09353333333334L 179.47916666666666 51.09353333333334L 179.47916666666666 161.348L 154.35208333333333 161.348"
                                                                    fill="rgba(0,123,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="0"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 154.35208333333333 161.348L 154.35208333333333 51.09353333333334L 179.47916666666666 51.09353333333334L 179.47916666666666 161.348L 154.35208333333333 161.348"
                                                                    pathFrom="M 154.35208333333333 161.348L 154.35208333333333 161.348L 179.47916666666666 161.348L 179.47916666666666 161.348L 154.35208333333333 161.348"
                                                                    cy="51.09353333333334" cx="226.14375" j="2"
                                                                    val="41" barWidth="25.127083333333335">
                                                                </path>
                                                                <path id="apexcharts-bar-area-0"
                                                                    d="M 226.14375 161.348L 226.14375 61.85006666666666L 251.27083333333334 61.85006666666666L 251.27083333333334 161.348L 226.14375 161.348"
                                                                    fill="rgba(0,123,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="0"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 226.14375 161.348L 226.14375 61.85006666666666L 251.27083333333334 61.85006666666666L 251.27083333333334 161.348L 226.14375 161.348"
                                                                    pathFrom="M 226.14375 161.348L 226.14375 161.348L 251.27083333333334 161.348L 251.27083333333334 161.348L 226.14375 161.348"
                                                                    cy="61.85006666666666" cx="297.9354166666667"
                                                                    j="3" val="37"
                                                                    barWidth="25.127083333333335"></path>
                                                                <path id="apexcharts-bar-area-0"
                                                                    d="M 297.9354166666667 161.348L 297.9354166666667 102.18706666666668L 323.06250000000006 102.18706666666668L 323.06250000000006 161.348L 297.9354166666667 161.348"
                                                                    fill="rgba(0,123,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="0"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 297.9354166666667 161.348L 297.9354166666667 102.18706666666668L 323.06250000000006 102.18706666666668L 323.06250000000006 161.348L 297.9354166666667 161.348"
                                                                    pathFrom="M 297.9354166666667 161.348L 297.9354166666667 161.348L 323.06250000000006 161.348L 323.06250000000006 161.348L 297.9354166666667 161.348"
                                                                    cy="102.18706666666668" cx="369.7270833333334"
                                                                    j="4" val="22"
                                                                    barWidth="25.127083333333335"></path>
                                                                <path id="apexcharts-bar-area-0"
                                                                    d="M 369.7270833333334 161.348L 369.7270833333334 45.715266666666665L 394.85416666666674 45.715266666666665L 394.85416666666674 161.348L 369.7270833333334 161.348"
                                                                    fill="rgba(0,123,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="0"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 369.7270833333334 161.348L 369.7270833333334 45.715266666666665L 394.85416666666674 45.715266666666665L 394.85416666666674 161.348L 369.7270833333334 161.348"
                                                                    pathFrom="M 369.7270833333334 161.348L 369.7270833333334 161.348L 394.85416666666674 161.348L 394.85416666666674 161.348L 369.7270833333334 161.348"
                                                                    cy="45.715266666666665" cx="441.51875000000007"
                                                                    j="5" val="43"
                                                                    barWidth="25.127083333333335"></path>
                                                                <g id="SvgjsG1499" class="apexcharts-datalabels">
                                                                </g>
                                                            </g>
                                                            <g id="SvgjsG1512" class="apexcharts-series Striking"
                                                                rel="2" data:realIndex="1">
                                                                <path id="apexcharts-bar-area-1"
                                                                    d="M 35.895833333333336 161.348L 35.895833333333336 18.823933333333343L 61.022916666666674 18.823933333333343L 61.022916666666674 161.348L 35.895833333333336 161.348"
                                                                    fill="rgba(22,170,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="1"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 35.895833333333336 161.348L 35.895833333333336 18.823933333333343L 61.022916666666674 18.823933333333343L 61.022916666666674 161.348L 35.895833333333336 161.348"
                                                                    pathFrom="M 35.895833333333336 161.348L 35.895833333333336 161.348L 61.022916666666674 161.348L 61.022916666666674 161.348L 35.895833333333336 161.348"
                                                                    cy="18.823933333333343" cx="107.6875" j="0"
                                                                    val="53" barWidth="25.127083333333335">
                                                                </path>
                                                                <path id="apexcharts-bar-area-1"
                                                                    d="M 107.6875 161.348L 107.6875 75.29573333333333L 132.81458333333333 75.29573333333333L 132.81458333333333 161.348L 107.6875 161.348"
                                                                    fill="rgba(22,170,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="1"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 107.6875 161.348L 107.6875 75.29573333333333L 132.81458333333333 75.29573333333333L 132.81458333333333 161.348L 107.6875 161.348"
                                                                    pathFrom="M 107.6875 161.348L 107.6875 161.348L 132.81458333333333 161.348L 132.81458333333333 161.348L 107.6875 161.348"
                                                                    cy="75.29573333333333" cx="179.47916666666666"
                                                                    j="1" val="32"
                                                                    barWidth="25.127083333333335"></path>
                                                                <path id="apexcharts-bar-area-1"
                                                                    d="M 179.47916666666666 161.348L 179.47916666666666 72.6066L 204.60625 72.6066L 204.60625 161.348L 179.47916666666666 161.348"
                                                                    fill="rgba(22,170,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="1"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 179.47916666666666 161.348L 179.47916666666666 72.6066L 204.60625 72.6066L 204.60625 161.348L 179.47916666666666 161.348"
                                                                    pathFrom="M 179.47916666666666 161.348L 179.47916666666666 161.348L 204.60625 161.348L 204.60625 161.348L 179.47916666666666 161.348"
                                                                    cy="72.6066" cx="251.27083333333334" j="2"
                                                                    val="33" barWidth="25.127083333333335">
                                                                </path>
                                                                <path id="apexcharts-bar-area-1"
                                                                    d="M 251.27083333333334 161.348L 251.27083333333334 21.513066666666674L 276.3979166666667 21.513066666666674L 276.3979166666667 161.348L 251.27083333333334 161.348"
                                                                    fill="rgba(22,170,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="1"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 251.27083333333334 161.348L 251.27083333333334 21.513066666666674L 276.3979166666667 21.513066666666674L 276.3979166666667 161.348L 251.27083333333334 161.348"
                                                                    pathFrom="M 251.27083333333334 161.348L 251.27083333333334 161.348L 276.3979166666667 161.348L 276.3979166666667 161.348L 251.27083333333334 161.348"
                                                                    cy="21.513066666666674" cx="323.06250000000006"
                                                                    j="3" val="52"
                                                                    barWidth="25.127083333333335"></path>
                                                                <path id="apexcharts-bar-area-1"
                                                                    d="M 323.06250000000006 161.348L 323.06250000000006 126.38926666666669L 348.1895833333334 126.38926666666669L 348.1895833333334 161.348L 323.06250000000006 161.348"
                                                                    fill="rgba(22,170,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="1"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 323.06250000000006 161.348L 323.06250000000006 126.38926666666669L 348.1895833333334 126.38926666666669L 348.1895833333334 161.348L 323.06250000000006 161.348"
                                                                    pathFrom="M 323.06250000000006 161.348L 323.06250000000006 161.348L 348.1895833333334 161.348L 348.1895833333334 161.348L 323.06250000000006 161.348"
                                                                    cy="126.38926666666669" cx="394.85416666666674"
                                                                    j="4" val="13"
                                                                    barWidth="25.127083333333335"></path>
                                                                <path id="apexcharts-bar-area-1"
                                                                    d="M 394.85416666666674 161.348L 394.85416666666674 45.715266666666665L 419.9812500000001 45.715266666666665L 419.9812500000001 161.348L 394.85416666666674 161.348"
                                                                    fill="rgba(22,170,255,0.8)" fill-opacity="1"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="0" stroke-dasharray="0"
                                                                    class="apexcharts-bar-area" index="1"
                                                                    clip-path="url(#gridRectMask5hdmgyll)"
                                                                    pathTo="M 394.85416666666674 161.348L 394.85416666666674 45.715266666666665L 419.9812500000001 45.715266666666665L 419.9812500000001 161.348L 394.85416666666674 161.348"
                                                                    pathFrom="M 394.85416666666674 161.348L 394.85416666666674 161.348L 419.9812500000001 161.348L 419.9812500000001 161.348L 394.85416666666674 161.348"
                                                                    cy="45.715266666666665" cx="466.6458333333334"
                                                                    j="5" val="43"
                                                                    barWidth="25.127083333333335"></path>
                                                                <g id="SvgjsG1513" class="apexcharts-datalabels">
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <line id="SvgjsLine1565" x1="0" y1="0"
                                                            x2="430.75" y2="0" stroke="#b6b6b6"
                                                            stroke-dasharray="0" stroke-width="1"
                                                            class="apexcharts-ycrosshairs"></line>
                                                        <line id="SvgjsLine1566" x1="0" y1="0"
                                                            x2="430.75" y2="0" stroke-dasharray="0"
                                                            stroke-width="0" class="apexcharts-ycrosshairs-hidden">
                                                        </line>
                                                        <g id="SvgjsG1567" class="apexcharts-yaxis-annotations"></g>
                                                        <g id="SvgjsG1568" class="apexcharts-xaxis-annotations"></g>
                                                        <g id="SvgjsG1569" class="apexcharts-point-annotations"></g>
                                                    </g>
                                                    <g id="SvgjsG1541" class="apexcharts-yaxis" rel="0"
                                                        transform="translate(2.25, 0)">
                                                        <g id="SvgjsG1542" class="apexcharts-yaxis-texts-g"><text
                                                                id="SvgjsText1543"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="41.6" text-anchor="end"
                                                                dominate-baseline="central" font-size="11px"
                                                                fill="#373d3f" class="apexcharts-yaxis-label"
                                                                style="font-family: Helvetica, Arial, sans-serif;">60</text><text
                                                                id="SvgjsText1544"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="68.59133333333332" text-anchor="end"
                                                                dominate-baseline="central" font-size="11px"
                                                                fill="#373d3f" class="apexcharts-yaxis-label"
                                                                style="font-family: Helvetica, Arial, sans-serif;">50</text><text
                                                                id="SvgjsText1545"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="95.58266666666665" text-anchor="end"
                                                                dominate-baseline="central" font-size="11px"
                                                                fill="#373d3f" class="apexcharts-yaxis-label"
                                                                style="font-family: Helvetica, Arial, sans-serif;">40</text><text
                                                                id="SvgjsText1546"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="122.57399999999998" text-anchor="end"
                                                                dominate-baseline="central" font-size="11px"
                                                                fill="#373d3f" class="apexcharts-yaxis-label"
                                                                style="font-family: Helvetica, Arial, sans-serif;">30</text><text
                                                                id="SvgjsText1547"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="149.5653333333333" text-anchor="end"
                                                                dominate-baseline="central" font-size="11px"
                                                                fill="#373d3f" class="apexcharts-yaxis-label"
                                                                style="font-family: Helvetica, Arial, sans-serif;">20</text><text
                                                                id="SvgjsText1548"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="176.55666666666664" text-anchor="end"
                                                                dominate-baseline="central" font-size="11px"
                                                                fill="#373d3f" class="apexcharts-yaxis-label"
                                                                style="font-family: Helvetica, Arial, sans-serif;">10</text><text
                                                                id="SvgjsText1549"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="203.54799999999997" text-anchor="end"
                                                                dominate-baseline="central" font-size="11px"
                                                                fill="#373d3f" class="apexcharts-yaxis-label"
                                                                style="font-family: Helvetica, Arial, sans-serif;">0</text>
                                                        </g>
                                                    </g>
                                                </svg>
                                                <div class="apexcharts-tooltip light"
                                                    style="left: 95.0219px; top: 19.25px;">
                                                    <div class="apexcharts-tooltip-title">1</div>
                                                    <div class="apexcharts-tooltip-series-group active"
                                                        style="display: flex;"><span
                                                            class="apexcharts-tooltip-marker"
                                                            style="background-color: rgb(22, 170, 255);"></span>
                                                        <div class="apexcharts-tooltip-text">
                                                            <div class="apexcharts-tooltip-y-group"><span
                                                                    class="apexcharts-tooltip-text-label">Striking:
                                                                </span><span
                                                                    class="apexcharts-tooltip-text-value">53K</span>
                                                            </div>
                                                            <div class="apexcharts-tooltip-z-group"><span
                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="apexcharts-tooltip-series-group"
                                                        style="display: none;"><span
                                                            class="apexcharts-tooltip-marker"
                                                            style="background-color: rgb(22, 170, 255);"></span>
                                                        <div class="apexcharts-tooltip-text">
                                                            <div class="apexcharts-tooltip-y-group"><span
                                                                    class="apexcharts-tooltip-text-label">Striking:
                                                                </span><span
                                                                    class="apexcharts-tooltip-text-value">53K</span>
                                                            </div>
                                                            <div class="apexcharts-tooltip-z-group"><span
                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="resize-triggers">
                                            <div class="expand-trigger">
                                                <div style="width: 489px; height: 280px;"></div>
                                            </div>
                                            <div class="contract-trigger"></div>
                                        </div>
                                    </div>
                                    <div class="mb-0 divider"></div>
                                    <div class="grid-menu grid-menu-2col">
                                        <div class="no-gutters row">
                                            <div class="p-2 col-sm-6">
                                                <button
                                                    class="pt-2 pb-2 btn-icon-vertical btn-transition-text btn-transition btn-transition-alt btn btn-outline-success">
                                                    <i
                                                        class="mb-2 lnr-lighter text-success opacity-7 btn-icon-wrapper">
                                                    </i> Accounts
                                                </button>
                                            </div>
                                            <div class="p-2 col-sm-6">
                                                <button
                                                    class="pt-2 pb-2 btn-icon-vertical btn-transition-text btn-transition btn-transition-alt btn btn-outline-alternate">
                                                    <i
                                                        class="mb-2 lnr-gift text-alternate opacity-7 btn-icon-wrapper">
                                                    </i> Services
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 main-card card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
                                        class="mr-3 header-icon lnr-dice text-muted opacity-6"> </i>Easy Dynamic
                                    Tables</div>
                                <div class="btn-actions-pane-right actions-icon-btn">
                                    <div class="btn-group dropdown">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" class="btn-icon btn-icon-only btn btn-link">
                                            <i class="pe-7s-menu btn-icon-wrapper"></i>
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu">
                                            <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <i class="dropdown-icon lnr-inbox"> </i><span>Menus</span>
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <i class="dropdown-icon lnr-file-empty">
                                                </i><span>Settings</span></button>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <i class="dropdown-icon lnr-book"> </i><span>Actions</span>
                                            </button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <div class="p-3 text-right">
                                                <button class="mr-2 btn-shadow btn-sm btn btn-link">View
                                                    Details</button>
                                                <button class="mr-2 btn-shadow btn-sm btn btn-primary">Action</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="bootstrap-table bootstrap4">
                                    <div class="fixed-table-toolbar"></div>

                                    <div class="fixed-table-container" style="padding-bottom: 0px;">
                                        <div class="fixed-table-header" style="display: none;">
                                            <table></table>
                                        </div>
                                        <div class="fixed-table-body">
                                            <div class="table fixed-table-loading table-bordered table-hover"
                                                style="top: 42px; display: none;">
                                                <span class="loading-wrap">
                                                    <span class="loading-text">Loading, please wait</span>
                                                    <span class="animation-wrap"><span
                                                            class="animation-dot"></span></span>
                                                </span>
                                            </div>
                                            <table data-toggle="table"
                                                data-url="https://api.github.com/users/wenzhixin/repos?type=owner&amp;sort=full_name&amp;direction=asc&amp;per_page=10&amp;page=1"
                                                data-sort-name="stargazers_count" data-sort-order="desc"
                                                class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="" data-field="name">
                                                            <div class="th-inner sortable both">
                                                                Name
                                                            </div>
                                                            <div class="fht-cell"></div>
                                                        </th>
                                                        <th style="" data-field="stargazers_count">
                                                            <div class="th-inner sortable both desc">
                                                                Stars
                                                            </div>
                                                            <div class="fht-cell"></div>
                                                        </th>
                                                        <th style="" data-field="forks_count">
                                                            <div class="th-inner sortable both">
                                                                Forks
                                                            </div>
                                                            <div class="fht-cell"></div>
                                                        </th>
                                                        <th style="" data-field="description">
                                                            <div class="th-inner sortable both">
                                                                Description
                                                            </div>
                                                            <div class="fht-cell"></div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr data-index="0">
                                                        <td style="">redmine-chrome</td>
                                                        <td style="">30</td>
                                                        <td style="">25</td>
                                                        <td style="">Redmine notification tools for chrome
                                                            extension.</td>
                                                    </tr>
                                                    <tr data-index="1">
                                                        <td style="">rest</td>
                                                        <td style="">10</td>
                                                        <td style="">6</td>
                                                        <td style="">Restful for jQuery</td>
                                                    </tr>
                                                    <tr data-index="2">
                                                        <td style="">bootstrap-pagination</td>
                                                        <td style="">5</td>
                                                        <td style="">5</td>
                                                        <td style="">jQuery bootstrap pagination plugin</td>
                                                    </tr>
                                                    <tr data-index="3">
                                                        <td style="">scutech-dbackup-login</td>
                                                        <td style="">4</td>
                                                        <td style="">2</td>
                                                        <td style="">迪备登录</td>
                                                    </tr>
                                                    <tr data-index="4">
                                                        <td style="">weibo-attention</td>
                                                        <td style="">2</td>
                                                        <td style="">0</td>
                                                        <td style="">为新版新浪微博添加相互关注(互相关注)功能</td>
                                                    </tr>
                                                    <tr data-index="5">
                                                        <td style="">scutech-todolist</td>
                                                        <td style="">1</td>
                                                        <td style="">0</td>
                                                        <td style="">todolist for chrome plugin.</td>
                                                    </tr>
                                                    <tr data-index="6">
                                                        <td style="">rest-tester</td>
                                                        <td style="">1</td>
                                                        <td style="">1</td>
                                                        <td style="">Tester for rest api</td>
                                                    </tr>
                                                    <tr data-index="7">
                                                        <td style="">seajs-helper</td>
                                                        <td style="">1</td>
                                                        <td style="">1</td>
                                                        <td style="">my seajs app helper</td>
                                                    </tr>
                                                    <tr data-index="8">
                                                        <td style="">node_util</td>
                                                        <td style="">0</td>
                                                        <td style="">0</td>
                                                        <td style="">nodejs util</td>
                                                    </tr>
                                                    <tr data-index="9">
                                                        <td style="">imagebox</td>
                                                        <td style="">0</td>
                                                        <td style="">1</td>
                                                        <td style="">图片查看弹出框</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="fixed-table-footer">
                                            <table>
                                                <thead>
                                                    <tr></tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="fixed-table-pagination" style="display: none;"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-md-6 col-lg-12">
                                        <div
                                            class="mb-3 card-hover-shadow-2x card-btm-border card-shadow-primary border-primary card">
                                            <div class="pb-0 rm-border mt-sm-3 responsive-center card-header">
                                                <div>
                                                    <h5
                                                        class="text-left menu-header-title text-capitalize fsize-2 text-muted opacity-6">
                                                        Received Messages</h5>
                                                </div>
                                            </div>
                                            <div class="p-0 text-left widget-chart widget-chart2">
                                                <div class="widget-chat-wrapper-outer">
                                                    <div class="pt-3 pl-5 pr-3 widget-chart-content">
                                                        <div class="widget-chart-flex">
                                                            <div class="widget-numbers">
                                                                <div class="widget-chart-flex">
                                                                    <div class="text-primary"><span>348</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="p-1 m-0 widget-chart-wrapper widget-chart-wrapper-lg he-auto opacity-3">
                                                        <div id="dashboard-sparkline-3" style="min-height: 152px;">
                                                            <div id="apexchartszk46wl2cl"
                                                                class="apexcharts-canvas apexchartszk46wl2cl"
                                                                style="width: 393px; height: 152px;"><svg
                                                                    id="SvgjsSvg1573" width="393"
                                                                    height="152"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    version="1.1"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    xmlns:svgjs="http://svgjs.com/svgjs"
                                                                    class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                                                    transform="translate(0, 0)"
                                                                    style="background: transparent;">
                                                                    <g id="SvgjsG1575"
                                                                        class="apexcharts-inner apexcharts-graphical"
                                                                        transform="translate(0, 0)">
                                                                        <defs id="SvgjsDefs1574">
                                                                            <clippath id="gridRectMaskzk46wl2cl">
                                                                                <rect id="SvgjsRect1578"
                                                                                    width="398" height="157"
                                                                                    x="-2.5" y="-2.5" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <clippath
                                                                                id="gridRectMarkerMaskzk46wl2cl">
                                                                                <rect id="SvgjsRect1579"
                                                                                    width="407" height="166"
                                                                                    x="-7" y="-7" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <lineargradient
                                                                                id="SvgjsLinearGradient1586"
                                                                                x1="0" y1="0"
                                                                                x2="0" y2="1">
                                                                                <stop id="SvgjsStop1587"
                                                                                    stop-opacity="0.7"
                                                                                    stop-color="rgba(58,196,125,0.7)"
                                                                                    offset="0"></stop>
                                                                                <stop id="SvgjsStop1588"
                                                                                    stop-opacity="0.9"
                                                                                    stop-color="rgba(255,255,255,0.9)"
                                                                                    offset="0.9"></stop>
                                                                                <stop id="SvgjsStop1589"
                                                                                    stop-opacity="0.9"
                                                                                    stop-color="rgba(255,255,255,0.9)"
                                                                                    offset="1"></stop>
                                                                            </lineargradient>
                                                                        </defs>
                                                                        <rect id="SvgjsRect1577" width="1"
                                                                            height="152" x="0" y="0"
                                                                            rx="0" ry="0"
                                                                            fill="#b1b9c4" opacity="1"
                                                                            stroke-width="0" stroke-dasharray="0"
                                                                            class="apexcharts-xcrosshairs"
                                                                            filter="none" fill-opacity="0.9">
                                                                        </rect>
                                                                        <g id="SvgjsG1591" class="apexcharts-xaxis"
                                                                            transform="translate(0, 0)">
                                                                            <g id="SvgjsG1592"
                                                                                class="apexcharts-xaxis-texts-g"
                                                                                transform="translate(0, -4)"></g>
                                                                        </g>
                                                                        <g id="SvgjsG1595" class="apexcharts-grid">
                                                                            <line id="SvgjsLine1597" x1="0"
                                                                                y1="152" x2="393"
                                                                                y2="152" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                            <line id="SvgjsLine1596" x1="0"
                                                                                y1="1" x2="0"
                                                                                y2="152" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                        </g>
                                                                        <g id="SvgjsG1581"
                                                                            class="apexcharts-area-series apexcharts-plot-series">
                                                                            <g id="SvgjsG1582"
                                                                                class="apexcharts-series series-1"
                                                                                data:longestSeries="true"
                                                                                rel="1" data:realIndex="0">
                                                                                <path id="apexcharts-area-0"
                                                                                    d="M 8.1875 103.57245632065775C 13.91875 103.57245632065775 18.83125 122.3186022610483 24.5625 122.3186022610483C 30.29375 122.3186022610483 35.20625 56.70709146968139 40.9375 56.70709146968139C 46.66875 56.70709146968139 51.58125 97.32374100719424 57.3125 97.32374100719424C 63.04375 97.32374100719424 67.95625 78.5775950668037 73.6875 78.5775950668037C 79.41875 78.5775950668037 84.33125 94.19938335046248 90.0625 94.19938335046248C 95.79375 94.19938335046248 100.70625 55.144912641315514 106.4375 55.144912641315514C 112.16875 55.144912641315514 117.08125 80.13977389516957 122.8125 80.13977389516957C 128.54375 80.13977389516957 133.45625 91.07502569373072 139.1875 91.07502569373072C 144.91875 91.07502569373072 149.83125 87.95066803699896 155.5625 87.95066803699896C 161.29375 87.95066803699896 166.20625 6.717368961973278 171.9375 6.717368961973278C 177.66875 6.717368961973278 182.58125 50.45837615621788 188.3125 50.45837615621788C 194.04375 50.45837615621788 198.95625 69.20452209660843 204.6875 69.20452209660843C 210.41875 69.20452209660843 215.33125 92.6372045220966 221.0625 92.6372045220966C 226.79375 92.6372045220966 231.70625 114.5077081192189 237.4375 114.5077081192189C 243.16875 114.5077081192189 248.08125 72.32887975334017 253.8125 72.32887975334017C 259.54375 72.32887975334017 264.45625 67.64234326824254 270.1875 67.64234326824254C 275.91875 67.64234326824254 280.83125 109.82117163412127 286.5625 109.82117163412127C 292.29375 109.82117163412127 297.20625 109.82117163412127 302.9375 109.82117163412127C 308.66875 109.82117163412127 313.58125 64.51798561151078 319.3125 64.51798561151078C 325.04375 64.51798561151078 329.95625 97.32374100719424 335.6875 97.32374100719424C 341.41875 97.32374100719424 346.33125 67.64234326824254 352.0625 67.64234326824254C 357.79375 67.64234326824254 362.70625 84.82631038026722 368.4375 84.82631038026722C 374.16875 84.82631038026722 379.08125 81.70195272353546 384.8125 81.70195272353546"
                                                                                    fill="none" fill-opacity="1"
                                                                                    stroke="#3ac47d"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="5"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-area"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMaskzk46wl2cl)"
                                                                                    pathTo="M 8.1875 103.57245632065775C 13.91875 103.57245632065775 18.83125 122.3186022610483 24.5625 122.3186022610483C 30.29375 122.3186022610483 35.20625 56.70709146968139 40.9375 56.70709146968139C 46.66875 56.70709146968139 51.58125 97.32374100719424 57.3125 97.32374100719424C 63.04375 97.32374100719424 67.95625 78.5775950668037 73.6875 78.5775950668037C 79.41875 78.5775950668037 84.33125 94.19938335046248 90.0625 94.19938335046248C 95.79375 94.19938335046248 100.70625 55.144912641315514 106.4375 55.144912641315514C 112.16875 55.144912641315514 117.08125 80.13977389516957 122.8125 80.13977389516957C 128.54375 80.13977389516957 133.45625 91.07502569373072 139.1875 91.07502569373072C 144.91875 91.07502569373072 149.83125 87.95066803699896 155.5625 87.95066803699896C 161.29375 87.95066803699896 166.20625 6.717368961973278 171.9375 6.717368961973278C 177.66875 6.717368961973278 182.58125 50.45837615621788 188.3125 50.45837615621788C 194.04375 50.45837615621788 198.95625 69.20452209660843 204.6875 69.20452209660843C 210.41875 69.20452209660843 215.33125 92.6372045220966 221.0625 92.6372045220966C 226.79375 92.6372045220966 231.70625 114.5077081192189 237.4375 114.5077081192189C 243.16875 114.5077081192189 248.08125 72.32887975334017 253.8125 72.32887975334017C 259.54375 72.32887975334017 264.45625 67.64234326824254 270.1875 67.64234326824254C 275.91875 67.64234326824254 280.83125 109.82117163412127 286.5625 109.82117163412127C 292.29375 109.82117163412127 297.20625 109.82117163412127 302.9375 109.82117163412127C 308.66875 109.82117163412127 313.58125 64.51798561151078 319.3125 64.51798561151078C 325.04375 64.51798561151078 329.95625 97.32374100719424 335.6875 97.32374100719424C 341.41875 97.32374100719424 346.33125 67.64234326824254 352.0625 67.64234326824254C 357.79375 67.64234326824254 362.70625 84.82631038026722 368.4375 84.82631038026722C 374.16875 84.82631038026722 379.08125 81.70195272353546 384.8125 81.70195272353546"
                                                                                    pathFrom="M -1 152L -1 152L 24.5625 152L 40.9375 152L 57.3125 152L 73.6875 152L 90.0625 152L 106.4375 152L 122.8125 152L 139.1875 152L 155.5625 152L 171.9375 152L 188.3125 152L 204.6875 152L 221.0625 152L 237.4375 152L 253.8125 152L 270.1875 152L 286.5625 152L 302.9375 152L 319.3125 152L 335.6875 152L 352.0625 152L 368.4375 152L 384.8125 152">
                                                                                </path>
                                                                                <path id="apexcharts-area-0"
                                                                                    d="M 8.1875 152L 8.1875 103.57245632065775C 13.91875 103.57245632065775 18.83125 122.3186022610483 24.5625 122.3186022610483C 30.29375 122.3186022610483 35.20625 56.70709146968139 40.9375 56.70709146968139C 46.66875 56.70709146968139 51.58125 97.32374100719424 57.3125 97.32374100719424C 63.04375 97.32374100719424 67.95625 78.5775950668037 73.6875 78.5775950668037C 79.41875 78.5775950668037 84.33125 94.19938335046248 90.0625 94.19938335046248C 95.79375 94.19938335046248 100.70625 55.144912641315514 106.4375 55.144912641315514C 112.16875 55.144912641315514 117.08125 80.13977389516957 122.8125 80.13977389516957C 128.54375 80.13977389516957 133.45625 91.07502569373072 139.1875 91.07502569373072C 144.91875 91.07502569373072 149.83125 87.95066803699896 155.5625 87.95066803699896C 161.29375 87.95066803699896 166.20625 6.717368961973278 171.9375 6.717368961973278C 177.66875 6.717368961973278 182.58125 50.45837615621788 188.3125 50.45837615621788C 194.04375 50.45837615621788 198.95625 69.20452209660843 204.6875 69.20452209660843C 210.41875 69.20452209660843 215.33125 92.6372045220966 221.0625 92.6372045220966C 226.79375 92.6372045220966 231.70625 114.5077081192189 237.4375 114.5077081192189C 243.16875 114.5077081192189 248.08125 72.32887975334017 253.8125 72.32887975334017C 259.54375 72.32887975334017 264.45625 67.64234326824254 270.1875 67.64234326824254C 275.91875 67.64234326824254 280.83125 109.82117163412127 286.5625 109.82117163412127C 292.29375 109.82117163412127 297.20625 109.82117163412127 302.9375 109.82117163412127C 308.66875 109.82117163412127 313.58125 64.51798561151078 319.3125 64.51798561151078C 325.04375 64.51798561151078 329.95625 97.32374100719424 335.6875 97.32374100719424C 341.41875 97.32374100719424 346.33125 67.64234326824254 352.0625 67.64234326824254C 357.79375 67.64234326824254 362.70625 84.82631038026722 368.4375 84.82631038026722C 374.16875 84.82631038026722 379.08125 81.70195272353546 384.8125 81.70195272353546C 384.8125 81.70195272353546 384.8125 81.70195272353546 384.8125 152M 384.8125 81.70195272353546z"
                                                                                    fill="url(#SvgjsLinearGradient1586)"
                                                                                    fill-opacity="1"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="0"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-area"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMaskzk46wl2cl)"
                                                                                    pathTo="M 8.1875 152L 8.1875 103.57245632065775C 13.91875 103.57245632065775 18.83125 122.3186022610483 24.5625 122.3186022610483C 30.29375 122.3186022610483 35.20625 56.70709146968139 40.9375 56.70709146968139C 46.66875 56.70709146968139 51.58125 97.32374100719424 57.3125 97.32374100719424C 63.04375 97.32374100719424 67.95625 78.5775950668037 73.6875 78.5775950668037C 79.41875 78.5775950668037 84.33125 94.19938335046248 90.0625 94.19938335046248C 95.79375 94.19938335046248 100.70625 55.144912641315514 106.4375 55.144912641315514C 112.16875 55.144912641315514 117.08125 80.13977389516957 122.8125 80.13977389516957C 128.54375 80.13977389516957 133.45625 91.07502569373072 139.1875 91.07502569373072C 144.91875 91.07502569373072 149.83125 87.95066803699896 155.5625 87.95066803699896C 161.29375 87.95066803699896 166.20625 6.717368961973278 171.9375 6.717368961973278C 177.66875 6.717368961973278 182.58125 50.45837615621788 188.3125 50.45837615621788C 194.04375 50.45837615621788 198.95625 69.20452209660843 204.6875 69.20452209660843C 210.41875 69.20452209660843 215.33125 92.6372045220966 221.0625 92.6372045220966C 226.79375 92.6372045220966 231.70625 114.5077081192189 237.4375 114.5077081192189C 243.16875 114.5077081192189 248.08125 72.32887975334017 253.8125 72.32887975334017C 259.54375 72.32887975334017 264.45625 67.64234326824254 270.1875 67.64234326824254C 275.91875 67.64234326824254 280.83125 109.82117163412127 286.5625 109.82117163412127C 292.29375 109.82117163412127 297.20625 109.82117163412127 302.9375 109.82117163412127C 308.66875 109.82117163412127 313.58125 64.51798561151078 319.3125 64.51798561151078C 325.04375 64.51798561151078 329.95625 97.32374100719424 335.6875 97.32374100719424C 341.41875 97.32374100719424 346.33125 67.64234326824254 352.0625 67.64234326824254C 357.79375 67.64234326824254 362.70625 84.82631038026722 368.4375 84.82631038026722C 374.16875 84.82631038026722 379.08125 81.70195272353546 384.8125 81.70195272353546C 384.8125 81.70195272353546 384.8125 81.70195272353546 384.8125 152M 384.8125 81.70195272353546z"
                                                                                    pathFrom="M -1 152L -1 152L 24.5625 152L 40.9375 152L 57.3125 152L 73.6875 152L 90.0625 152L 106.4375 152L 122.8125 152L 139.1875 152L 155.5625 152L 171.9375 152L 188.3125 152L 204.6875 152L 221.0625 152L 237.4375 152L 253.8125 152L 270.1875 152L 286.5625 152L 302.9375 152L 319.3125 152L 335.6875 152L 352.0625 152L 368.4375 152L 384.8125 152">
                                                                                </path>
                                                                                <g id="SvgjsG1583"
                                                                                    class="apexcharts-series-markers-wrap">
                                                                                    <g
                                                                                        class="apexcharts-series-markers">
                                                                                        <circle id="SvgjsCircle1603"
                                                                                            r="0" cx="0"
                                                                                            cy="0"
                                                                                            class="apexcharts-marker wx9r8ny85 no-pointer-events"
                                                                                            stroke="#ffffff"
                                                                                            fill="#3ac47d"
                                                                                            fill-opacity="1"
                                                                                            stroke-width="2"
                                                                                            stroke-opacity="0.9"
                                                                                            default-marker-size="0">
                                                                                        </circle>
                                                                                    </g>
                                                                                </g>
                                                                                <g id="SvgjsG1584"
                                                                                    class="apexcharts-datalabels"></g>
                                                                            </g>
                                                                        </g>
                                                                        <line id="SvgjsLine1598" x1="0"
                                                                            y1="0" x2="393"
                                                                            y2="0" stroke="#b6b6b6"
                                                                            stroke-dasharray="0" stroke-width="1"
                                                                            class="apexcharts-ycrosshairs"></line>
                                                                        <line id="SvgjsLine1599" x1="0"
                                                                            y1="0" x2="393"
                                                                            y2="0" stroke-dasharray="0"
                                                                            stroke-width="0"
                                                                            class="apexcharts-ycrosshairs-hidden">
                                                                        </line>
                                                                        <g id="SvgjsG1600"
                                                                            class="apexcharts-yaxis-annotations"></g>
                                                                        <g id="SvgjsG1601"
                                                                            class="apexcharts-xaxis-annotations"></g>
                                                                        <g id="SvgjsG1602"
                                                                            class="apexcharts-point-annotations"></g>
                                                                    </g>
                                                                    <g id="SvgjsG1593" class="apexcharts-yaxis"
                                                                        rel="0"
                                                                        transform="translate(-35, 0)">
                                                                        <g id="SvgjsG1594"
                                                                            class="apexcharts-yaxis-texts-g"></g>
                                                                    </g>
                                                                </svg>
                                                                <div class="apexcharts-legend"></div>
                                                                <div class="apexcharts-tooltip light">
                                                                    <div class="apexcharts-tooltip-series-group"><span
                                                                            class="apexcharts-tooltip-marker"
                                                                            style="background-color: rgb(58, 196, 125);"></span>
                                                                        <div class="apexcharts-tooltip-text">
                                                                            <div class="apexcharts-tooltip-y-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-label"></span><span
                                                                                    class="apexcharts-tooltip-text-value"></span>
                                                                            </div>
                                                                            <div class="apexcharts-tooltip-z-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="resize-triggers">
                                                            <div class="expand-trigger">
                                                                <div style="width: 402px; height: 161px;"></div>
                                                            </div>
                                                            <div class="contract-trigger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12">
                                        <div
                                            class="mb-3 card-hover-shadow-2x card-btm-border card-shadow-danger border-danger card">
                                            <div class="pb-0 rm-border mt-sm-3 responsive-center card-header">
                                                <div>
                                                    <h5
                                                        class="text-left menu-header-title text-capitalize fsize-2 text-muted opacity-6">
                                                        Sent Messages</h5>
                                                </div>
                                            </div>
                                            <div class="p-0 text-left widget-chart widget-chart2">
                                                <div class="widget-chat-wrapper-outer">
                                                    <div class="pt-3 pl-5 pr-3 widget-chart-content">
                                                        <div class="widget-chart-flex">
                                                            <div class="widget-numbers">
                                                                <div class="widget-chart-flex">
                                                                    <div class="text-danger"><span>425</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="p-1 m-0 widget-chart-wrapper widget-chart-wrapper-lg he-auto opacity-3">
                                                        <div id="dashboard-sparkline-2" style="min-height: 152px;">
                                                            <div id="apexchartsxb9occmr"
                                                                class="apexcharts-canvas apexchartsxb9occmr"
                                                                style="width: 393px; height: 152px;"><svg
                                                                    id="SvgjsSvg1607" width="393"
                                                                    height="152"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    version="1.1"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    xmlns:svgjs="http://svgjs.com/svgjs"
                                                                    class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                                                    transform="translate(0, 0)"
                                                                    style="background: transparent;">
                                                                    <g id="SvgjsG1609"
                                                                        class="apexcharts-inner apexcharts-graphical"
                                                                        transform="translate(0, 0)">
                                                                        <defs id="SvgjsDefs1608">
                                                                            <clippath id="gridRectMaskxb9occmr">
                                                                                <rect id="SvgjsRect1612"
                                                                                    width="398" height="157"
                                                                                    x="-2.5" y="-2.5" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <clippath id="gridRectMarkerMaskxb9occmr">
                                                                                <rect id="SvgjsRect1613"
                                                                                    width="407" height="166"
                                                                                    x="-7" y="-7" rx="0"
                                                                                    ry="0" fill="#ffffff"
                                                                                    opacity="1" stroke-width="0"
                                                                                    stroke="none"
                                                                                    stroke-dasharray="0"></rect>
                                                                            </clippath>
                                                                            <lineargradient
                                                                                id="SvgjsLinearGradient1620"
                                                                                x1="0" y1="0"
                                                                                x2="0" y2="1">
                                                                                <stop id="SvgjsStop1621"
                                                                                    stop-opacity="0.7"
                                                                                    stop-color="rgba(247,185,36,0.7)"
                                                                                    offset="0"></stop>
                                                                                <stop id="SvgjsStop1622"
                                                                                    stop-opacity="0.9"
                                                                                    stop-color="rgba(255,255,255,0.9)"
                                                                                    offset="0.9"></stop>
                                                                                <stop id="SvgjsStop1623"
                                                                                    stop-opacity="0.9"
                                                                                    stop-color="rgba(255,255,255,0.9)"
                                                                                    offset="1"></stop>
                                                                            </lineargradient>
                                                                        </defs>
                                                                        <rect id="SvgjsRect1611" width="1"
                                                                            height="152" x="0" y="0"
                                                                            rx="0" ry="0"
                                                                            fill="#b1b9c4" opacity="1"
                                                                            stroke-width="0" stroke-dasharray="0"
                                                                            class="apexcharts-xcrosshairs"
                                                                            filter="none" fill-opacity="0.9">
                                                                        </rect>
                                                                        <g id="SvgjsG1625" class="apexcharts-xaxis"
                                                                            transform="translate(0, 0)">
                                                                            <g id="SvgjsG1626"
                                                                                class="apexcharts-xaxis-texts-g"
                                                                                transform="translate(0, -4)"></g>
                                                                        </g>
                                                                        <g id="SvgjsG1629" class="apexcharts-grid">
                                                                            <line id="SvgjsLine1631" x1="0"
                                                                                y1="152" x2="393"
                                                                                y2="152" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                            <line id="SvgjsLine1630" x1="0"
                                                                                y1="1" x2="0"
                                                                                y2="152" stroke="transparent"
                                                                                stroke-dasharray="0"></line>
                                                                        </g>
                                                                        <g id="SvgjsG1615"
                                                                            class="apexcharts-area-series apexcharts-plot-series">
                                                                            <g id="SvgjsG1616"
                                                                                class="apexcharts-series series-1"
                                                                                data:longestSeries="true"
                                                                                rel="1" data:realIndex="0">
                                                                                <path id="apexcharts-area-0"
                                                                                    d="M 8.1875 55.144912641315514C 13.91875 55.144912641315514 18.83125 92.6372045220966 24.5625 92.6372045220966C 30.29375 92.6372045220966 35.20625 72.32887975334017 40.9375 72.32887975334017C 46.66875 72.32887975334017 51.58125 84.82631038026722 57.3125 84.82631038026722C 63.04375 84.82631038026722 67.95625 109.82117163412127 73.6875 109.82117163412127C 79.41875 109.82117163412127 84.33125 69.20452209660843 90.0625 69.20452209660843C 95.79375 69.20452209660843 100.70625 114.5077081192189 106.4375 114.5077081192189C 112.16875 114.5077081192189 117.08125 94.19938335046248 122.8125 94.19938335046248C 128.54375 94.19938335046248 133.45625 87.95066803699896 139.1875 87.95066803699896C 144.91875 87.95066803699896 149.83125 122.3186022610483 155.5625 122.3186022610483C 161.29375 122.3186022610483 166.20625 109.82117163412127 171.9375 109.82117163412127C 177.66875 109.82117163412127 182.58125 6.717368961973278 188.3125 6.717368961973278C 194.04375 6.717368961973278 198.95625 80.13977389516957 204.6875 80.13977389516957C 210.41875 80.13977389516957 215.33125 64.51798561151078 221.0625 64.51798561151078C 226.79375 64.51798561151078 231.70625 56.70709146968139 237.4375 56.70709146968139C 243.16875 56.70709146968139 248.08125 97.32374100719424 253.8125 97.32374100719424C 259.54375 97.32374100719424 264.45625 103.57245632065775 270.1875 103.57245632065775C 275.91875 103.57245632065775 280.83125 67.64234326824254 286.5625 67.64234326824254C 292.29375 67.64234326824254 297.20625 78.5775950668037 302.9375 78.5775950668037C 308.66875 78.5775950668037 313.58125 67.64234326824254 319.3125 67.64234326824254C 325.04375 67.64234326824254 329.95625 50.45837615621788 335.6875 50.45837615621788C 341.41875 50.45837615621788 346.33125 97.32374100719424 352.0625 97.32374100719424C 357.79375 97.32374100719424 362.70625 91.07502569373072 368.4375 91.07502569373072C 374.16875 91.07502569373072 379.08125 81.70195272353546 384.8125 81.70195272353546"
                                                                                    fill="none" fill-opacity="1"
                                                                                    stroke="#f7b924"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="5"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-area"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMaskxb9occmr)"
                                                                                    pathTo="M 8.1875 55.144912641315514C 13.91875 55.144912641315514 18.83125 92.6372045220966 24.5625 92.6372045220966C 30.29375 92.6372045220966 35.20625 72.32887975334017 40.9375 72.32887975334017C 46.66875 72.32887975334017 51.58125 84.82631038026722 57.3125 84.82631038026722C 63.04375 84.82631038026722 67.95625 109.82117163412127 73.6875 109.82117163412127C 79.41875 109.82117163412127 84.33125 69.20452209660843 90.0625 69.20452209660843C 95.79375 69.20452209660843 100.70625 114.5077081192189 106.4375 114.5077081192189C 112.16875 114.5077081192189 117.08125 94.19938335046248 122.8125 94.19938335046248C 128.54375 94.19938335046248 133.45625 87.95066803699896 139.1875 87.95066803699896C 144.91875 87.95066803699896 149.83125 122.3186022610483 155.5625 122.3186022610483C 161.29375 122.3186022610483 166.20625 109.82117163412127 171.9375 109.82117163412127C 177.66875 109.82117163412127 182.58125 6.717368961973278 188.3125 6.717368961973278C 194.04375 6.717368961973278 198.95625 80.13977389516957 204.6875 80.13977389516957C 210.41875 80.13977389516957 215.33125 64.51798561151078 221.0625 64.51798561151078C 226.79375 64.51798561151078 231.70625 56.70709146968139 237.4375 56.70709146968139C 243.16875 56.70709146968139 248.08125 97.32374100719424 253.8125 97.32374100719424C 259.54375 97.32374100719424 264.45625 103.57245632065775 270.1875 103.57245632065775C 275.91875 103.57245632065775 280.83125 67.64234326824254 286.5625 67.64234326824254C 292.29375 67.64234326824254 297.20625 78.5775950668037 302.9375 78.5775950668037C 308.66875 78.5775950668037 313.58125 67.64234326824254 319.3125 67.64234326824254C 325.04375 67.64234326824254 329.95625 50.45837615621788 335.6875 50.45837615621788C 341.41875 50.45837615621788 346.33125 97.32374100719424 352.0625 97.32374100719424C 357.79375 97.32374100719424 362.70625 91.07502569373072 368.4375 91.07502569373072C 374.16875 91.07502569373072 379.08125 81.70195272353546 384.8125 81.70195272353546"
                                                                                    pathFrom="M -1 152L -1 152L 24.5625 152L 40.9375 152L 57.3125 152L 73.6875 152L 90.0625 152L 106.4375 152L 122.8125 152L 139.1875 152L 155.5625 152L 171.9375 152L 188.3125 152L 204.6875 152L 221.0625 152L 237.4375 152L 253.8125 152L 270.1875 152L 286.5625 152L 302.9375 152L 319.3125 152L 335.6875 152L 352.0625 152L 368.4375 152L 384.8125 152">
                                                                                </path>
                                                                                <path id="apexcharts-area-0"
                                                                                    d="M 8.1875 152L 8.1875 55.144912641315514C 13.91875 55.144912641315514 18.83125 92.6372045220966 24.5625 92.6372045220966C 30.29375 92.6372045220966 35.20625 72.32887975334017 40.9375 72.32887975334017C 46.66875 72.32887975334017 51.58125 84.82631038026722 57.3125 84.82631038026722C 63.04375 84.82631038026722 67.95625 109.82117163412127 73.6875 109.82117163412127C 79.41875 109.82117163412127 84.33125 69.20452209660843 90.0625 69.20452209660843C 95.79375 69.20452209660843 100.70625 114.5077081192189 106.4375 114.5077081192189C 112.16875 114.5077081192189 117.08125 94.19938335046248 122.8125 94.19938335046248C 128.54375 94.19938335046248 133.45625 87.95066803699896 139.1875 87.95066803699896C 144.91875 87.95066803699896 149.83125 122.3186022610483 155.5625 122.3186022610483C 161.29375 122.3186022610483 166.20625 109.82117163412127 171.9375 109.82117163412127C 177.66875 109.82117163412127 182.58125 6.717368961973278 188.3125 6.717368961973278C 194.04375 6.717368961973278 198.95625 80.13977389516957 204.6875 80.13977389516957C 210.41875 80.13977389516957 215.33125 64.51798561151078 221.0625 64.51798561151078C 226.79375 64.51798561151078 231.70625 56.70709146968139 237.4375 56.70709146968139C 243.16875 56.70709146968139 248.08125 97.32374100719424 253.8125 97.32374100719424C 259.54375 97.32374100719424 264.45625 103.57245632065775 270.1875 103.57245632065775C 275.91875 103.57245632065775 280.83125 67.64234326824254 286.5625 67.64234326824254C 292.29375 67.64234326824254 297.20625 78.5775950668037 302.9375 78.5775950668037C 308.66875 78.5775950668037 313.58125 67.64234326824254 319.3125 67.64234326824254C 325.04375 67.64234326824254 329.95625 50.45837615621788 335.6875 50.45837615621788C 341.41875 50.45837615621788 346.33125 97.32374100719424 352.0625 97.32374100719424C 357.79375 97.32374100719424 362.70625 91.07502569373072 368.4375 91.07502569373072C 374.16875 91.07502569373072 379.08125 81.70195272353546 384.8125 81.70195272353546C 384.8125 81.70195272353546 384.8125 81.70195272353546 384.8125 152M 384.8125 81.70195272353546z"
                                                                                    fill="url(#SvgjsLinearGradient1620)"
                                                                                    fill-opacity="1"
                                                                                    stroke-opacity="1"
                                                                                    stroke-linecap="butt"
                                                                                    stroke-width="0"
                                                                                    stroke-dasharray="0"
                                                                                    class="apexcharts-area"
                                                                                    index="0"
                                                                                    clip-path="url(#gridRectMaskxb9occmr)"
                                                                                    pathTo="M 8.1875 152L 8.1875 55.144912641315514C 13.91875 55.144912641315514 18.83125 92.6372045220966 24.5625 92.6372045220966C 30.29375 92.6372045220966 35.20625 72.32887975334017 40.9375 72.32887975334017C 46.66875 72.32887975334017 51.58125 84.82631038026722 57.3125 84.82631038026722C 63.04375 84.82631038026722 67.95625 109.82117163412127 73.6875 109.82117163412127C 79.41875 109.82117163412127 84.33125 69.20452209660843 90.0625 69.20452209660843C 95.79375 69.20452209660843 100.70625 114.5077081192189 106.4375 114.5077081192189C 112.16875 114.5077081192189 117.08125 94.19938335046248 122.8125 94.19938335046248C 128.54375 94.19938335046248 133.45625 87.95066803699896 139.1875 87.95066803699896C 144.91875 87.95066803699896 149.83125 122.3186022610483 155.5625 122.3186022610483C 161.29375 122.3186022610483 166.20625 109.82117163412127 171.9375 109.82117163412127C 177.66875 109.82117163412127 182.58125 6.717368961973278 188.3125 6.717368961973278C 194.04375 6.717368961973278 198.95625 80.13977389516957 204.6875 80.13977389516957C 210.41875 80.13977389516957 215.33125 64.51798561151078 221.0625 64.51798561151078C 226.79375 64.51798561151078 231.70625 56.70709146968139 237.4375 56.70709146968139C 243.16875 56.70709146968139 248.08125 97.32374100719424 253.8125 97.32374100719424C 259.54375 97.32374100719424 264.45625 103.57245632065775 270.1875 103.57245632065775C 275.91875 103.57245632065775 280.83125 67.64234326824254 286.5625 67.64234326824254C 292.29375 67.64234326824254 297.20625 78.5775950668037 302.9375 78.5775950668037C 308.66875 78.5775950668037 313.58125 67.64234326824254 319.3125 67.64234326824254C 325.04375 67.64234326824254 329.95625 50.45837615621788 335.6875 50.45837615621788C 341.41875 50.45837615621788 346.33125 97.32374100719424 352.0625 97.32374100719424C 357.79375 97.32374100719424 362.70625 91.07502569373072 368.4375 91.07502569373072C 374.16875 91.07502569373072 379.08125 81.70195272353546 384.8125 81.70195272353546C 384.8125 81.70195272353546 384.8125 81.70195272353546 384.8125 152M 384.8125 81.70195272353546z"
                                                                                    pathFrom="M -1 152L -1 152L 24.5625 152L 40.9375 152L 57.3125 152L 73.6875 152L 90.0625 152L 106.4375 152L 122.8125 152L 139.1875 152L 155.5625 152L 171.9375 152L 188.3125 152L 204.6875 152L 221.0625 152L 237.4375 152L 253.8125 152L 270.1875 152L 286.5625 152L 302.9375 152L 319.3125 152L 335.6875 152L 352.0625 152L 368.4375 152L 384.8125 152">
                                                                                </path>
                                                                                <g id="SvgjsG1617"
                                                                                    class="apexcharts-series-markers-wrap">
                                                                                    <g
                                                                                        class="apexcharts-series-markers">
                                                                                        <circle id="SvgjsCircle1637"
                                                                                            r="0" cx="0"
                                                                                            cy="0"
                                                                                            class="apexcharts-marker w4batlhy4 no-pointer-events"
                                                                                            stroke="#ffffff"
                                                                                            fill="#f7b924"
                                                                                            fill-opacity="1"
                                                                                            stroke-width="2"
                                                                                            stroke-opacity="0.9"
                                                                                            default-marker-size="0">
                                                                                        </circle>
                                                                                    </g>
                                                                                </g>
                                                                                <g id="SvgjsG1618"
                                                                                    class="apexcharts-datalabels"></g>
                                                                            </g>
                                                                        </g>
                                                                        <line id="SvgjsLine1632" x1="0"
                                                                            y1="0" x2="393"
                                                                            y2="0" stroke="#b6b6b6"
                                                                            stroke-dasharray="0" stroke-width="1"
                                                                            class="apexcharts-ycrosshairs"></line>
                                                                        <line id="SvgjsLine1633" x1="0"
                                                                            y1="0" x2="393"
                                                                            y2="0" stroke-dasharray="0"
                                                                            stroke-width="0"
                                                                            class="apexcharts-ycrosshairs-hidden">
                                                                        </line>
                                                                        <g id="SvgjsG1634"
                                                                            class="apexcharts-yaxis-annotations"></g>
                                                                        <g id="SvgjsG1635"
                                                                            class="apexcharts-xaxis-annotations"></g>
                                                                        <g id="SvgjsG1636"
                                                                            class="apexcharts-point-annotations"></g>
                                                                    </g>
                                                                    <g id="SvgjsG1627" class="apexcharts-yaxis"
                                                                        rel="0"
                                                                        transform="translate(-35, 0)">
                                                                        <g id="SvgjsG1628"
                                                                            class="apexcharts-yaxis-texts-g"></g>
                                                                    </g>
                                                                </svg>
                                                                <div class="apexcharts-legend"></div>
                                                                <div class="apexcharts-tooltip light">
                                                                    <div class="apexcharts-tooltip-series-group"><span
                                                                            class="apexcharts-tooltip-marker"
                                                                            style="background-color: rgb(247, 185, 36);"></span>
                                                                        <div class="apexcharts-tooltip-text">
                                                                            <div class="apexcharts-tooltip-y-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-label"></span><span
                                                                                    class="apexcharts-tooltip-text-value"></span>
                                                                            </div>
                                                                            <div class="apexcharts-tooltip-z-group">
                                                                                <span
                                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="resize-triggers">
                                                            <div class="expand-trigger">
                                                                <div style="width: 402px; height: 161px;"></div>
                                                            </div>
                                                            <div class="contract-trigger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header-tab-animation card-header">
                                        <div class="card-header-title">
                                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                                            Sales Report
                                        </div>
                                        <div class="btn-actions-pane-right text-capitalize">
                                            <button
                                                class="btn-wide btn-outline-2x btn btn-outline-success btn-sm">View
                                                All</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="tab-eg-11">
                                                <div class="p-0 mb-3 text-left card widget-chart widget-chart2">
                                                    <div class="widget-chat-wrapper-outer">
                                                        <div class="pt-3 pl-3 pr-3 widget-chart-content">
                                                            <div class="widget-chart-flex">
                                                                <div class="widget-numbers">
                                                                    <div class="widget-chart-flex">
                                                                        <div>
                                                                            <small class="opacity-5">$</small>
                                                                            <span>368</span>
                                                                        </div>
                                                                        <div
                                                                            class="ml-2 widget-title opacity-5 font-size-lg text-muted">
                                                                            Total Leads</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="m-0 widget-chart-wrapper he-auto opacity-10">
                                                            <div id="dashboard-sparkline-carousel-2"
                                                                style="min-height: 120px;">
                                                                <div id="apexchartse1bu8kb5"
                                                                    class="apexcharts-canvas apexchartse1bu8kb5"
                                                                    style="width: 532px; height: 120px;"><svg
                                                                        id="SvgjsSvg1640" width="532"
                                                                        height="120"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        version="1.1"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        xmlns:svgjs="http://svgjs.com/svgjs"
                                                                        class="apexcharts-svg"
                                                                        xmlns:data="ApexChartsNS"
                                                                        transform="translate(0, 0)"
                                                                        style="background: transparent;">
                                                                        <g id="SvgjsG1642"
                                                                            class="apexcharts-inner apexcharts-graphical"
                                                                            transform="translate(0, 0)">
                                                                            <defs id="SvgjsDefs1641">
                                                                                <lineargradient
                                                                                    id="SvgjsLinearGradient1644"
                                                                                    x1="0" y1="0"
                                                                                    x2="0" y2="1">
                                                                                    <stop id="SvgjsStop1645"
                                                                                        stop-opacity="0.4"
                                                                                        stop-color="rgba(216,227,240,0.4)"
                                                                                        offset="0"></stop>
                                                                                    <stop id="SvgjsStop1646"
                                                                                        stop-opacity="0.5"
                                                                                        stop-color="rgba(190,209,230,0.5)"
                                                                                        offset="1"></stop>
                                                                                    <stop id="SvgjsStop1647"
                                                                                        stop-opacity="0.5"
                                                                                        stop-color="rgba(190,209,230,0.5)"
                                                                                        offset="1"></stop>
                                                                                </lineargradient>
                                                                                <clippath id="gridRectMaske1bu8kb5">
                                                                                    <rect id="SvgjsRect1649"
                                                                                        width="535"
                                                                                        height="123" x="-1.5"
                                                                                        y="-1.5" rx="0"
                                                                                        ry="0"
                                                                                        fill="#ffffff"
                                                                                        opacity="1"
                                                                                        stroke-width="0"
                                                                                        stroke="none"
                                                                                        stroke-dasharray="0"></rect>
                                                                                </clippath>
                                                                                <clippath
                                                                                    id="gridRectMarkerMaske1bu8kb5">
                                                                                    <rect id="SvgjsRect1650"
                                                                                        width="540"
                                                                                        height="128" x="-4" y="-4"
                                                                                        rx="0"
                                                                                        ry="0"
                                                                                        fill="#ffffff"
                                                                                        opacity="1"
                                                                                        stroke-width="0"
                                                                                        stroke="none"
                                                                                        stroke-dasharray="0"></rect>
                                                                                </clippath>
                                                                            </defs>
                                                                            <rect id="SvgjsRect1648" width="0"
                                                                                height="120" x="0" y="0"
                                                                                rx="0" ry="0"
                                                                                fill="url(#SvgjsLinearGradient1644)"
                                                                                opacity="1" stroke-width="0"
                                                                                stroke-dasharray="0"
                                                                                class="apexcharts-xcrosshairs"
                                                                                filter="none" fill-opacity="0.9">
                                                                            </rect>
                                                                            <g id="SvgjsG1703"
                                                                                class="apexcharts-xaxis"
                                                                                transform="translate(0, 0)">
                                                                                <g id="SvgjsG1704"
                                                                                    class="apexcharts-xaxis-texts-g"
                                                                                    transform="translate(0, -4)"></g>
                                                                            </g>
                                                                            <g id="SvgjsG1707"
                                                                                class="apexcharts-grid">
                                                                                <line id="SvgjsLine1709"
                                                                                    x1="0" y1="120"
                                                                                    x2="532" y2="120"
                                                                                    stroke="transparent"
                                                                                    stroke-dasharray="0"></line>
                                                                                <line id="SvgjsLine1708"
                                                                                    x1="0" y1="1"
                                                                                    x2="0" y2="120"
                                                                                    stroke="transparent"
                                                                                    stroke-dasharray="0"></line>
                                                                            </g>
                                                                            <g id="SvgjsG1652"
                                                                                class="apexcharts-bar-series apexcharts-plot-series"
                                                                                clip-path="url(#gridRectMaske1bu8kb5)">
                                                                                <g id="SvgjsG1653"
                                                                                    class="apexcharts-series series-1"
                                                                                    rel="1"
                                                                                    data:realIndex="0">
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 3.325 120L 3.325 74.83870967741936L 15.841666666666669 74.83870967741936L 15.841666666666669 120L 3.325 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 3.325 120L 3.325 74.83870967741936L 15.841666666666669 74.83870967741936L 15.841666666666669 120L 3.325 120"
                                                                                        pathFrom="M 3.325 120L 3.325 120L 15.841666666666669 120L 15.841666666666669 120L 3.325 120"
                                                                                        cy="74.83870967741936"
                                                                                        cx="23.991666666666667" j="0"
                                                                                        val="35"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 25.491666666666667 120L 25.491666666666667 85.16129032258064L 38.00833333333333 85.16129032258064L 38.00833333333333 120L 25.491666666666667 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 25.491666666666667 120L 25.491666666666667 85.16129032258064L 38.00833333333333 85.16129032258064L 38.00833333333333 120L 25.491666666666667 120"
                                                                                        pathFrom="M 25.491666666666667 120L 25.491666666666667 120L 38.00833333333333 120L 38.00833333333333 120L 25.491666666666667 120"
                                                                                        cy="85.16129032258064"
                                                                                        cx="46.15833333333333" j="1"
                                                                                        val="27"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 47.65833333333333 120L 47.65833333333333 59.35483870967742L 60.175 59.35483870967742L 60.175 120L 47.65833333333333 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 47.65833333333333 120L 47.65833333333333 59.35483870967742L 60.175 59.35483870967742L 60.175 120L 47.65833333333333 120"
                                                                                        pathFrom="M 47.65833333333333 120L 47.65833333333333 120L 60.175 120L 60.175 120L 47.65833333333333 120"
                                                                                        cy="59.35483870967742"
                                                                                        cx="68.325" j="2"
                                                                                        val="47"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 69.825 120L 69.825 50.322580645161295L 82.34166666666667 50.322580645161295L 82.34166666666667 120L 69.825 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 69.825 120L 69.825 50.322580645161295L 82.34166666666667 50.322580645161295L 82.34166666666667 120L 69.825 120"
                                                                                        pathFrom="M 69.825 120L 69.825 120L 82.34166666666667 120L 82.34166666666667 120L 69.825 120"
                                                                                        cy="50.322580645161295"
                                                                                        cx="90.49166666666667" j="3"
                                                                                        val="54"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 91.99166666666667 120L 91.99166666666667 69.67741935483872L 104.50833333333334 69.67741935483872L 104.50833333333334 120L 91.99166666666667 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 91.99166666666667 120L 91.99166666666667 69.67741935483872L 104.50833333333334 69.67741935483872L 104.50833333333334 120L 91.99166666666667 120"
                                                                                        pathFrom="M 91.99166666666667 120L 91.99166666666667 120L 104.50833333333334 120L 104.50833333333334 120L 91.99166666666667 120"
                                                                                        cy="69.67741935483872"
                                                                                        cx="112.65833333333335" j="4"
                                                                                        val="39"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 114.15833333333335 120L 114.15833333333335 60.645161290322584L 126.67500000000001 60.645161290322584L 126.67500000000001 120L 114.15833333333335 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 114.15833333333335 120L 114.15833333333335 60.645161290322584L 126.67500000000001 60.645161290322584L 126.67500000000001 120L 114.15833333333335 120"
                                                                                        pathFrom="M 114.15833333333335 120L 114.15833333333335 120L 126.67500000000001 120L 126.67500000000001 120L 114.15833333333335 120"
                                                                                        cy="60.645161290322584"
                                                                                        cx="134.82500000000002" j="5"
                                                                                        val="46"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 136.32500000000002 120L 136.32500000000002 47.741935483870975L 148.8416666666667 47.741935483870975L 148.8416666666667 120L 136.32500000000002 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 136.32500000000002 120L 136.32500000000002 47.741935483870975L 148.8416666666667 47.741935483870975L 148.8416666666667 120L 136.32500000000002 120"
                                                                                        pathFrom="M 136.32500000000002 120L 136.32500000000002 120L 148.8416666666667 120L 148.8416666666667 120L 136.32500000000002 120"
                                                                                        cy="47.741935483870975"
                                                                                        cx="156.99166666666667" j="6"
                                                                                        val="56"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 158.49166666666667 120L 158.49166666666667 54.19354838709678L 171.00833333333335 54.19354838709678L 171.00833333333335 120L 158.49166666666667 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 158.49166666666667 120L 158.49166666666667 54.19354838709678L 171.00833333333335 54.19354838709678L 171.00833333333335 120L 158.49166666666667 120"
                                                                                        pathFrom="M 158.49166666666667 120L 158.49166666666667 120L 171.00833333333335 120L 171.00833333333335 120L 158.49166666666667 120"
                                                                                        cy="54.19354838709678"
                                                                                        cx="179.15833333333333" j="7"
                                                                                        val="51"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 180.65833333333333 120L 180.65833333333333 70.96774193548387L 193.175 70.96774193548387L 193.175 120L 180.65833333333333 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 180.65833333333333 120L 180.65833333333333 70.96774193548387L 193.175 70.96774193548387L 193.175 120L 180.65833333333333 120"
                                                                                        pathFrom="M 180.65833333333333 120L 180.65833333333333 120L 193.175 120L 193.175 120L 180.65833333333333 120"
                                                                                        cy="70.96774193548387"
                                                                                        cx="201.325" j="8"
                                                                                        val="38"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 202.825 120L 202.825 36.12903225806451L 215.34166666666667 36.12903225806451L 215.34166666666667 120L 202.825 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 202.825 120L 202.825 36.12903225806451L 215.34166666666667 36.12903225806451L 215.34166666666667 120L 202.825 120"
                                                                                        pathFrom="M 202.825 120L 202.825 120L 215.34166666666667 120L 215.34166666666667 120L 202.825 120"
                                                                                        cy="36.12903225806451"
                                                                                        cx="223.49166666666665" j="9"
                                                                                        val="65"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 224.99166666666665 120L 224.99166666666665 40L 237.50833333333333 40L 237.50833333333333 120L 224.99166666666665 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 224.99166666666665 120L 224.99166666666665 40L 237.50833333333333 40L 237.50833333333333 120L 224.99166666666665 120"
                                                                                        pathFrom="M 224.99166666666665 120L 224.99166666666665 120L 237.50833333333333 120L 237.50833333333333 120L 224.99166666666665 120"
                                                                                        cy="40"
                                                                                        cx="245.6583333333333" j="10"
                                                                                        val="62"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 247.1583333333333 120L 247.1583333333333 41.29032258064517L 259.67499999999995 41.29032258064517L 259.67499999999995 120L 247.1583333333333 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 247.1583333333333 120L 247.1583333333333 41.29032258064517L 259.67499999999995 41.29032258064517L 259.67499999999995 120L 247.1583333333333 120"
                                                                                        pathFrom="M 247.1583333333333 120L 247.1583333333333 120L 259.67499999999995 120L 259.67499999999995 120L 247.1583333333333 120"
                                                                                        cy="41.29032258064517"
                                                                                        cx="267.825" j="11"
                                                                                        val="61"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 269.325 120L 269.325 0L 281.84166666666664 0L 281.84166666666664 120L 269.325 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 269.325 120L 269.325 0L 281.84166666666664 0L 281.84166666666664 120L 269.325 120"
                                                                                        pathFrom="M 269.325 120L 269.325 120L 281.84166666666664 120L 281.84166666666664 120L 269.325 120"
                                                                                        cy="0"
                                                                                        cx="289.9916666666667" j="12"
                                                                                        val="93"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 291.4916666666667 120L 291.4916666666667 61.935483870967744L 304.0083333333333 61.935483870967744L 304.0083333333333 120L 291.4916666666667 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 291.4916666666667 120L 291.4916666666667 61.935483870967744L 304.0083333333333 61.935483870967744L 304.0083333333333 120L 291.4916666666667 120"
                                                                                        pathFrom="M 291.4916666666667 120L 291.4916666666667 120L 304.0083333333333 120L 304.0083333333333 120L 291.4916666666667 120"
                                                                                        cy="61.935483870967744"
                                                                                        cx="312.15833333333336" j="13"
                                                                                        val="45"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 313.65833333333336 120L 313.65833333333336 80L 326.175 80L 326.175 120L 313.65833333333336 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 313.65833333333336 120L 313.65833333333336 80L 326.175 80L 326.175 120L 313.65833333333336 120"
                                                                                        pathFrom="M 313.65833333333336 120L 313.65833333333336 120L 326.175 120L 326.175 120L 313.65833333333336 120"
                                                                                        cy="80"
                                                                                        cx="334.32500000000005" j="14"
                                                                                        val="31"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 335.82500000000005 120L 335.82500000000005 89.03225806451613L 348.3416666666667 89.03225806451613L 348.3416666666667 120L 335.82500000000005 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 335.82500000000005 120L 335.82500000000005 89.03225806451613L 348.3416666666667 89.03225806451613L 348.3416666666667 120L 335.82500000000005 120"
                                                                                        pathFrom="M 335.82500000000005 120L 335.82500000000005 120L 348.3416666666667 120L 348.3416666666667 120L 335.82500000000005 120"
                                                                                        cy="89.03225806451613"
                                                                                        cx="356.49166666666673" j="15"
                                                                                        val="24"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 357.99166666666673 120L 357.99166666666673 72.25806451612902L 370.5083333333334 72.25806451612902L 370.5083333333334 120L 357.99166666666673 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 357.99166666666673 120L 357.99166666666673 72.25806451612902L 370.5083333333334 72.25806451612902L 370.5083333333334 120L 357.99166666666673 120"
                                                                                        pathFrom="M 357.99166666666673 120L 357.99166666666673 120L 370.5083333333334 120L 370.5083333333334 120L 357.99166666666673 120"
                                                                                        cy="72.25806451612902"
                                                                                        cx="378.6583333333334" j="16"
                                                                                        val="37"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 380.1583333333334 120L 380.1583333333334 74.83870967741936L 392.67500000000007 74.83870967741936L 392.67500000000007 120L 380.1583333333334 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 380.1583333333334 120L 380.1583333333334 74.83870967741936L 392.67500000000007 74.83870967741936L 392.67500000000007 120L 380.1583333333334 120"
                                                                                        pathFrom="M 380.1583333333334 120L 380.1583333333334 120L 392.67500000000007 120L 392.67500000000007 120L 380.1583333333334 120"
                                                                                        cy="74.83870967741936"
                                                                                        cx="400.8250000000001" j="17"
                                                                                        val="35"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 402.3250000000001 120L 402.3250000000001 50.322580645161295L 414.84166666666675 50.322580645161295L 414.84166666666675 120L 402.3250000000001 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 402.3250000000001 120L 402.3250000000001 50.322580645161295L 414.84166666666675 50.322580645161295L 414.84166666666675 120L 402.3250000000001 120"
                                                                                        pathFrom="M 402.3250000000001 120L 402.3250000000001 120L 414.84166666666675 120L 414.84166666666675 120L 402.3250000000001 120"
                                                                                        cy="50.322580645161295"
                                                                                        cx="422.9916666666668" j="18"
                                                                                        val="54"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 424.4916666666668 120L 424.4916666666668 67.09677419354838L 437.00833333333344 67.09677419354838L 437.00833333333344 120L 424.4916666666668 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 424.4916666666668 120L 424.4916666666668 67.09677419354838L 437.00833333333344 67.09677419354838L 437.00833333333344 120L 424.4916666666668 120"
                                                                                        pathFrom="M 424.4916666666668 120L 424.4916666666668 120L 437.00833333333344 120L 437.00833333333344 120L 424.4916666666668 120"
                                                                                        cy="67.09677419354838"
                                                                                        cx="445.1583333333335" j="19"
                                                                                        val="41"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 446.6583333333335 120L 446.6583333333335 85.16129032258064L 459.1750000000001 85.16129032258064L 459.1750000000001 120L 446.6583333333335 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 446.6583333333335 120L 446.6583333333335 85.16129032258064L 459.1750000000001 85.16129032258064L 459.1750000000001 120L 446.6583333333335 120"
                                                                                        pathFrom="M 446.6583333333335 120L 446.6583333333335 120L 459.1750000000001 120L 459.1750000000001 120L 446.6583333333335 120"
                                                                                        cy="85.16129032258064"
                                                                                        cx="467.32500000000016" j="20"
                                                                                        val="27"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 468.82500000000016 120L 468.82500000000016 51.61290322580645L 481.3416666666668 51.61290322580645L 481.3416666666668 120L 468.82500000000016 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 468.82500000000016 120L 468.82500000000016 51.61290322580645L 481.3416666666668 51.61290322580645L 481.3416666666668 120L 468.82500000000016 120"
                                                                                        pathFrom="M 468.82500000000016 120L 468.82500000000016 120L 481.3416666666668 120L 481.3416666666668 120L 468.82500000000016 120"
                                                                                        cy="51.61290322580645"
                                                                                        cx="489.49166666666684" j="21"
                                                                                        val="53"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 490.99166666666684 120L 490.99166666666684 64.51612903225806L 503.5083333333335 64.51612903225806L 503.5083333333335 120L 490.99166666666684 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 490.99166666666684 120L 490.99166666666684 64.51612903225806L 503.5083333333335 64.51612903225806L 503.5083333333335 120L 490.99166666666684 120"
                                                                                        pathFrom="M 490.99166666666684 120L 490.99166666666684 120L 503.5083333333335 120L 503.5083333333335 120L 490.99166666666684 120"
                                                                                        cy="64.51612903225806"
                                                                                        cx="511.65833333333353" j="22"
                                                                                        val="43"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <path id="apexcharts-bar-area-0"
                                                                                        d="M 513.1583333333335 120L 513.1583333333335 95.48387096774194L 525.6750000000002 95.48387096774194L 525.6750000000002 120L 513.1583333333335 120"
                                                                                        fill="rgba(0,123,255,0.85)"
                                                                                        fill-opacity="1"
                                                                                        stroke="#007bff"
                                                                                        stroke-opacity="1"
                                                                                        stroke-linecap="butt"
                                                                                        stroke-width="3"
                                                                                        stroke-dasharray="0"
                                                                                        class="apexcharts-bar-area"
                                                                                        index="0"
                                                                                        clip-path="url(#gridRectMaske1bu8kb5)"
                                                                                        pathTo="M 513.1583333333335 120L 513.1583333333335 95.48387096774194L 525.6750000000002 95.48387096774194L 525.6750000000002 120L 513.1583333333335 120"
                                                                                        pathFrom="M 513.1583333333335 120L 513.1583333333335 120L 525.6750000000002 120L 525.6750000000002 120L 513.1583333333335 120"
                                                                                        cy="95.48387096774194"
                                                                                        cx="533.8250000000002" j="23"
                                                                                        val="19"
                                                                                        barWidth="15.516666666666667">
                                                                                    </path>
                                                                                    <g id="SvgjsG1654"
                                                                                        class="apexcharts-datalabels">
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <line id="SvgjsLine1710" x1="0"
                                                                                y1="0" x2="532"
                                                                                y2="0" stroke="#b6b6b6"
                                                                                stroke-dasharray="0"
                                                                                stroke-width="1"
                                                                                class="apexcharts-ycrosshairs"></line>
                                                                            <line id="SvgjsLine1711" x1="0"
                                                                                y1="0" x2="532"
                                                                                y2="0" stroke-dasharray="0"
                                                                                stroke-width="0"
                                                                                class="apexcharts-ycrosshairs-hidden">
                                                                            </line>
                                                                            <g id="SvgjsG1712"
                                                                                class="apexcharts-yaxis-annotations">
                                                                            </g>
                                                                            <g id="SvgjsG1713"
                                                                                class="apexcharts-xaxis-annotations">
                                                                            </g>
                                                                            <g id="SvgjsG1714"
                                                                                class="apexcharts-point-annotations">
                                                                            </g>
                                                                        </g>
                                                                        <g id="SvgjsG1705" class="apexcharts-yaxis"
                                                                            rel="0"
                                                                            transform="translate(-35, 0)">
                                                                            <g id="SvgjsG1706"
                                                                                class="apexcharts-yaxis-texts-g"></g>
                                                                        </g>
                                                                    </svg>
                                                                    <div class="apexcharts-legend"></div>
                                                                </div>
                                                            </div>
                                                            <div class="resize-triggers">
                                                                <div class="expand-trigger">
                                                                    <div style="width: 533px; height: 121px;"></div>
                                                                </div>
                                                                <div class="contract-trigger"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h6
                                                    class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">
                                                    Top
                                                    Authors</h6>
                                                <div class="scroll-area-sm">
                                                    <div class="scrollbar-container ps ps--active-y">
                                                        <ul
                                                            class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="p-0 widget-content">
                                                                    <div class="widget-content-wrapper">
                                                                        <div class="mr-3 widget-content-left">
                                                                            <img width="42"
                                                                                class="rounded-circle"
                                                                                src="{{ asset('backend') }}/9.jpg"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading">Ella-Rose
                                                                                Henry</div>
                                                                            <div class="widget-subheading">Web
                                                                                Developer</div>
                                                                        </div>
                                                                        <div class="widget-content-right">
                                                                            <div class="font-size-xlg text-muted">
                                                                                <small
                                                                                    class="pr-1 opacity-5">$</small>
                                                                                <span>129</span>
                                                                                <small class="pl-2 text-danger">
                                                                                    <i class="fa fa-angle-down"></i>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="p-0 widget-content">
                                                                    <div class="widget-content-wrapper">
                                                                        <div class="mr-3 widget-content-left">
                                                                            <img width="42"
                                                                                class="rounded-circle"
                                                                                src="{{ asset('backend') }}/5.jpg"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading">Ruben Tillman
                                                                            </div>
                                                                            <div class="widget-subheading">UI Designer
                                                                            </div>
                                                                        </div>
                                                                        <div class="widget-content-right">
                                                                            <div class="font-size-xlg text-muted">
                                                                                <small
                                                                                    class="pr-1 opacity-5">$</small>
                                                                                <span>54</span>
                                                                                <small class="pl-2 text-success">
                                                                                    <i class="fa fa-angle-up"></i>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="p-0 widget-content">
                                                                    <div class="widget-content-wrapper">
                                                                        <div class="mr-3 widget-content-left">
                                                                            <img width="42"
                                                                                class="rounded-circle"
                                                                                src="{{ asset('backend') }}/4.jpg"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading">Vinnie
                                                                                Wagstaff</div>
                                                                            <div class="widget-subheading">Java
                                                                                Programmer</div>
                                                                        </div>
                                                                        <div class="widget-content-right">
                                                                            <div class="font-size-xlg text-muted">
                                                                                <small
                                                                                    class="pr-1 opacity-5">$</small>
                                                                                <span>429</span>
                                                                                <small class="pl-2 text-warning">
                                                                                    <i class="fa fa-dot-circle"></i>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="p-0 widget-content">
                                                                    <div class="widget-content-wrapper">
                                                                        <div class="mr-3 widget-content-left">
                                                                            <img width="42"
                                                                                class="rounded-circle"
                                                                                src="{{ asset('backend') }}/3.jpg"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading">Ella-Rose
                                                                                Henry</div>
                                                                            <div class="widget-subheading">Web
                                                                                Developer</div>
                                                                        </div>
                                                                        <div class="widget-content-right">
                                                                            <div class="font-size-xlg text-muted">
                                                                                <small
                                                                                    class="pr-1 opacity-5">$</small>
                                                                                <span>129</span>
                                                                                <small class="pl-2 text-danger">
                                                                                    <i class="fa fa-angle-down"></i>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="p-0 widget-content">
                                                                    <div class="widget-content-wrapper">
                                                                        <div class="mr-3 widget-content-left">
                                                                            <img width="42"
                                                                                class="rounded-circle"
                                                                                src="{{ asset('backend') }}/2.jpg"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="widget-content-left">
                                                                            <div class="widget-heading">Ruben Tillman
                                                                            </div>
                                                                            <div class="widget-subheading">UI Designer
                                                                            </div>
                                                                        </div>
                                                                        <div class="widget-content-right">
                                                                            <div class="font-size-xlg text-muted">
                                                                                <small
                                                                                    class="pr-1 opacity-5">$</small>
                                                                                <span>54</span>
                                                                                <small class="pl-2 text-success">
                                                                                    <i class="fa fa-angle-up"></i>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                            <div class="ps__thumb-x" tabindex="0"
                                                                style="left: 0px; width: 0px;"></div>
                                                        </div>
                                                        <div class="ps__rail-y"
                                                            style="top: 0px; height: 200px; right: 0px;">
                                                            <div class="ps__thumb-y" tabindex="0"
                                                                style="top: 0px; height: 139px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="divider"></div>
                                                <h6
                                                    class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">
                                                    Last
                                                    Month Top Seller</h6>
                                                <ul
                                                    class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <div class="p-0 widget-content">
                                                            <div class="widget-content-wrapper">
                                                                <div class="mr-3 widget-content-left">
                                                                    <img width="42" class="rounded-circle"
                                                                        src="{{ asset('backend') }}/8.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">Ruben Tillman</div>
                                                                    <div class="widget-subheading">UI Designer</div>
                                                                </div>
                                                                <div class="widget-content-right">
                                                                    <div class="font-size-xlg text-muted">
                                                                        <small class="pr-1 opacity-5">$</small>
                                                                        <span>54</span>
                                                                        <small class="pl-2 text-success">
                                                                            <i class="fa fa-angle-up">
                                                                            </i>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-center">
                            <h5 class="mb-3 menu-header-title text-capitalize fsize-3">Cards</h5>
                            <div role="group" class="mb-3 btn-group-sm btn-group">
                                <button class="btn-shadow btn btn-dark">Hour</button>
                                <button class="btn-hover-shine btn btn-dark">Day</button>
                                <button class="btn-hover-shine btn btn-dark">Week</button>
                                <button class="btn-hover-shine btn btn-dark">Month</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-4">
                                <div class="mb-3 text-white card-shadow-primary card-border card bg-primary">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-primary">
                                            <div class="menu-header-content">
                                                <div class="mb-3 avatar-icon-wrapper avatar-icon-xl">
                                                    <div class="avatar-icon"><img
                                                            src="{{ asset('backend') }}/3.jpg"
                                                            alt="Avatar 5">
                                                    </div>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">Jessica Walberg</h5>
                                                    <h6 class="menu-header-subtitle">Lead UX Developer</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center d-block card-footer">
                                        <button class="btn-shadow-dark btn-wider btn btn-dark">Send Message</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-4">
                                <div class="mb-3 text-white card-shadow-primary card-border card bg-focus">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-focus">
                                            <div class="menu-header-content">
                                                <div class="mb-3 avatar-icon-wrapper avatar-icon-xl">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/2.jpg"
                                                            alt="Avatar 5">
                                                    </div>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">Vinnie Wagstaff</h5>
                                                    <h6 class="menu-header-subtitle">Backend Engineer</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center d-block card-footer">
                                        <button class="btn-shadow-dark btn-wider btn btn-warning">Send
                                            Message</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xl-4">
                                <div class="mb-3 text-white card-shadow-primary card-border card bg-dark">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-dark">
                                            <div class="menu-header-content">
                                                <div class="mb-3 avatar-icon-wrapper avatar-icon-xl">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/1.jpg"
                                                            alt="Avatar 5">
                                                    </div>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">Ruben Tillman</h5>
                                                    <h6 class="menu-header-subtitle">Frontend UI Designer</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center d-block card-footer">
                                        <button class="btn-shadow-dark btn-wider btn btn-success">Send
                                            Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

@endsection
