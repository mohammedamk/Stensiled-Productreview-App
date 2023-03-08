<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" /> -->
    <link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@4.15.2/styles.min.css" />
    <style>
        .Polaris-DataTable__Cell--numeric {
            text-align: left;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</head>

<body>
    <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
        <div class="Polaris-Page">
            <div class="Polaris-Page-Header Polaris-Page-Header--separator Polaris-Page-Header--mobileView">
                <div class="Polaris-Page-Header__MainContent">
                    <div class="Polaris-Page-Header__TitleActionMenuWrapper">
                        <div>
                            <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                                <div class="Polaris-Header-Title">
                                    <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Reviews</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
                <div class="Polaris-Card">
                    <div>
                        <div class="Polaris-Tabs__Wrapper">
                            <ul role="tablist" class="Polaris-Tabs">
                                <li class="Polaris-Tabs__TabContainer"><button id="all-customers" role="tab" type="button" tabindex="0" class="Polaris-Tabs__Tab Polaris-Tabs__Tab--selected" aria-selected="true" aria-controls="all-customers-content" aria-label="All customers"><span class="Polaris-Tabs__Title">All Reviews</span></button></li>
                                <li class="Polaris-Tabs__TabContainer"><button id="accepts-marketing" role="tab" type="button" tabindex="-1" class="Polaris-Tabs__Tab" aria-selected="false" aria-controls="accepts-marketing-content"><span class="Polaris-Tabs__Title">Unpublished</span></button></li>
                                <li class="Polaris-Tabs__TabContainer"><button id="repeat-customers" role="tab" type="button" tabindex="-1" class="Polaris-Tabs__Tab" aria-selected="false" aria-controls="repeat-customers-content"><span class="Polaris-Tabs__Title">Published</span></button></li>
                                <li class="Polaris-Tabs__TabContainer"><button id="prospects" role="tab" type="button" tabindex="-1" class="Polaris-Tabs__Tab" aria-selected="false" aria-controls="prospects-content"><span class="Polaris-Tabs__Title">Flagged</span></button></li>

                            </ul>
                            <div class="Polaris-Tabs Polaris-Tabs__TabMeasurer">
                                <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
                                    <div class="Polaris-Page">
                                        <div class="Polaris-Page__Content">
                                            <div class="Polaris-Card">
                                                <div class="">
                                                    <div class="Polaris-DataTable__Navigation"><button type="button" class="Polaris-Button Polaris-Button--disabled Polaris-Button--plain Polaris-Button--iconOnly" disabled="" aria-label="Scroll table left one column"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                            <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>
                                                                        </svg></span></span></span></button><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Scroll table right one column"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                            <path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16" fill-rule="evenodd"></path>
                                                                        </svg></span></span></span></button></div>
                                                    <div class="Polaris-DataTable">
                                                        <div class="Polaris-DataTable__ScrollContainer">
                                                            <table class="Polaris-DataTable__Table" id="example">
                                                                <thead>
                                                                    <tr>
                                                                        <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--header" scope="col">Product</th>
                                                                        <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Price</th>
                                                                        <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">SKU Number</th>
                                                                        <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Quantity</th>
                                                                        <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Net sales</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--total" scope="row">Totals</th>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total"></td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total"></td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total Polaris-DataTable__Cell--numeric">255</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--total Polaris-DataTable__Cell--numeric">$155,830.00</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="Polaris-DataTable__TableRow">
                                                                        <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row"><a class="Polaris-Link" href="https://www.example.com" data-polaris-unstyled="true">Emerald Silk Gown</a></th>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$875.00</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">124689</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">140</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$122,500.00</td>
                                                                    </tr>
                                                                    <tr class="Polaris-DataTable__TableRow">
                                                                        <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row"><a class="Polaris-Link" href="https://www.example.com" data-polaris-unstyled="true">Mauve Cashmere Scarf</a></th>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$230.00</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">124533</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">83</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$19,090.00</td>
                                                                    </tr>
                                                                    <tr class="Polaris-DataTable__TableRow">
                                                                        <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row"><a class="Polaris-Link" href="https://www.example.com" data-polaris-unstyled="true">Navy Merino Wool Blazer with khaki chinos and yellow belt</a></th>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$445.00</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">124518</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">32</td>
                                                                        <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$14,240.00</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Polaris-Tabs__Panel" id="all-customers-content" role="tabpanel" aria-labelledby="all-customers" tabindex="-1">
                            <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
                                <div class="Polaris-Page">
                                    <div class="Polaris-Page__Content">
                                        <div class="Polaris-Card">
                                            <div class="">
                                                <div class="Polaris-DataTable__Navigation"><button type="button" class="Polaris-Button Polaris-Button--disabled Polaris-Button--plain Polaris-Button--iconOnly" disabled="" aria-label="Scroll table left one column"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                        <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>
                                                                    </svg></span></span></span></button><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Scroll table right one column"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                        <path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16" fill-rule="evenodd"></path>
                                                                    </svg></span></span></span></button></div>
                                                <div class="Polaris-DataTable">
                                                    <div class="Polaris-DataTable__ScrollContainer">
                                                        <table class="Polaris-DataTable__Table">
                                                            <thead>
                                                                <tr>
                                                                    <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--header" scope="col" aria-sort="none">
                                                                        <label class="Polaris-Choice" for="PolarisCheckbox2"><span class="Polaris-Choice__Control"><span class="Polaris-Checkbox"><input id="PolarisCheckbox2" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value=""><span class="Polaris-Checkbox__Backdrop"></span><span class="Polaris-Checkbox__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                                                <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                                                                            </svg></span></span></span></span><span class="Polaris-Choice__Label"></span></label>
                                                                    </th>
                                                                    <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric Polaris-DataTable__Cell--sortable Polaris-DataTable__Cell--sorted" scope="col" aria-sort="descending"><button class="Polaris-DataTable__Heading"><span class="Polaris-DataTable__Icon"><span class="Polaris-Icon" aria-label="sort ascending by"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                                        <path d="M5 8l5 5 5-5z" fill-rule="evenodd"></path>
                                                                                    </svg></span></span>Rating</button></th>
                                                                    <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--header" scope="col" aria-sort="none">Review</th>
                                                                    <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric Polaris-DataTable__Cell--sortable Polaris-DataTable__Cell--sorted" scope="col" aria-sort="descending"><button class="Polaris-DataTable__Heading"><span class="Polaris-DataTable__Icon"><span class="Polaris-Icon" aria-label="sort ascending by"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                                        <path d="M5 8l5 5 5-5z" fill-rule="evenodd"></path>
                                                                                    </svg></span></span>Date</button></th>
                                                                    <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric Polaris-DataTable__Cell--sortable Polaris-DataTable__Cell--sorted" scope="col" aria-sort="descending"><button class="Polaris-DataTable__Heading"><span class="Polaris-DataTable__Icon"><span class="Polaris-Icon" aria-label="sort ascending by"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                                        <path d="M5 8l5 5 5-5z" fill-rule="evenodd"></path>
                                                                                    </svg></span></span>Status</button></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="Polaris-DataTable__TableRow">
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                                                        <label class="Polaris-Choice" for="PolarisCheckbox3"><span class="Polaris-Choice__Control"><span class="Polaris-Checkbox"><input id="PolarisCheckbox3" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value=""><span class="Polaris-Checkbox__Backdrop"></span><span class="Polaris-Checkbox__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                                                <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                                                                            </svg></span></span></span></span><span class="Polaris-Choice__Label"></span></label>
                                                                    </td>
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$875.00</td>
                                                                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row">
                                                                        <a data-nested-link-target="true" href="/reviews/85820361">good quality</a>
                                                                        <p>
                                                                            cotton shirt, good fabric

                                                                        </p>
                                                                        <span class="subdued">– rashmi on <a class="subdued" href="/products/7733629">U.S. POLO ASSN.</a></span>
                                                                    </th>
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">124689</td>
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">140</td>
                                                                </tr>
                                                                <tr class="Polaris-DataTable__TableRow">
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                                                        <label class="Polaris-Choice" for="PolarisCheckbox3"><span class="Polaris-Choice__Control"><span class="Polaris-Checkbox"><input id="PolarisCheckbox3" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value=""><span class="Polaris-Checkbox__Backdrop"></span><span class="Polaris-Checkbox__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                                                <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                                                                            </svg></span></span></span></span><span class="Polaris-Choice__Label"></span></label>
                                                                    </td>
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">$875.00</td>
                                                                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row">
                                                                        <a data-nested-link-target="true" href="/reviews/85820361">good quality</a>
                                                                        <p>
                                                                            cotton shirt, good fabric

                                                                        </p>
                                                                        <span class="subdued">– rashmi on <a class="subdued" href="/products/7733629">U.S. POLO ASSN.</a></span>
                                                                    </th>
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">124689</td>
                                                                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">140</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Polaris-Tabs__Panel Polaris-Tabs__Panel--hidden" id="accepts-marketing-content" role="tabpanel" aria-labelledby="accepts-marketing" tabindex="-1"></div>
                        <div class="Polaris-Tabs__Panel Polaris-Tabs__Panel--hidden" id="repeat-customers-content" role="tabpanel" aria-labelledby="repeat-customers" tabindex="-1"></div>
                        <div class="Polaris-Tabs__Panel Polaris-Tabs__Panel--hidden" id="prospects-content" role="tabpanel" aria-labelledby="prospects" tabindex="-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>