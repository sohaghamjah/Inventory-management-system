@extends('layouts.app')

@section('content')
<div class="dt-content">

    <!-- Grid -->
    <div class="row">

      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6">

        <!-- Chart Card -->
        <div class="dt-card dt-chart dt-card__full-height">

          <!-- Chart Header -->
          <div class="dt-chart__header">
            <div class="style-default style-crypto">
              <h2>$9,626</h2>

              <div class="trending-section text-success">
                <h4>38%</h4>
                <i class="icon icon-menu-up"></i>
              </div>

              <p>Bitcoin Price</p>
            </div>
          </div>
          <!-- /chart header -->

          <!-- Action Tools -->
          <div class="action-tools">
            <i class="icon icon-bitcoin icon-3x text-primary"></i>
          </div>
          <!-- /action tools -->

          <!-- Chart Body -->
          <div class="dt-chart__body">
            <canvas class="rounded-xl" id="chart-active-users" height="96" data-shadow="yes"></canvas>
          </div>
          <!-- /chart body -->

        </div>
        <!-- /chart card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6">

        <!-- Chart Card -->
        <div class="dt-card dt-chart dt-card__full-height">

          <!-- Chart Header -->
          <div class="dt-chart__header">
            <div class="style-default style-crypto">
              <h2>$7,831</h2>

              <div class="trending-section text-success">
                <h4>07%</h4>
                <i class="icon icon-menu-up"></i>
              </div>

              <p>Etherium Price</p>
            </div>
          </div>
          <!-- /chart header -->

          <!-- Action Tools -->
          <div class="action-tools">
            <i class="icon icon-etherium icon-3x text-primary"></i>
          </div>
          <!-- /action tools -->

          <!-- Chart Body -->
          <div class="dt-chart__body">
            <canvas class="rounded-xl" id="chart-extra-revenue" height="96" data-shadow="yes"></canvas>
          </div>
          <!-- /chart body -->

        </div>
        <!-- /chart card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6">

        <!-- Chart Card -->
        <div class="dt-card dt-chart dt-card__full-height">

          <!-- Chart Header -->
          <div class="dt-chart__header">
            <div class="style-default style-crypto">
              <h2>$1,239</h2>

              <div class="trending-section text-danger">
                <h4>08%</h4>
                <i class="icon icon-menu-down"></i>
              </div>

              <p>Ripple Price</p>
            </div>
          </div>
          <!-- /chart header -->

          <!-- Action Tools -->
          <div class="action-tools">
            <i class="icon icon-ripple icon-3x text-primary"></i>
          </div>
          <!-- /action tools -->

          <!-- Chart Body -->
          <div class="dt-chart__body">
            <canvas class="rounded-xl" id="chart-orders" height="96" data-shadow="yes"></canvas>
          </div>
          <!-- /chart body -->

        </div>
        <!-- /chart card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-3 col-sm-6">

        <!-- Chart Card -->
        <div class="dt-card dt-chart dt-card__full-height">

          <!-- Chart Header -->
          <div class="dt-chart__header">
            <div class="style-default style-crypto">
              <h2>$849</h2>

              <div class="trending-section text-danger">
                <h4>47%</h4>
                <i class="icon icon-menu-down"></i>
              </div>

              <p>Litcoin Price</p>
            </div>
          </div>
          <!-- /chart header -->

          <!-- Action Tools -->
          <div class="action-tools">
            <i class="icon icon-litcoin icon-3x text-primary"></i>
          </div>
          <!-- /action tools -->

          <!-- Chart Body -->
          <div class="dt-chart__body">
            <canvas class="rounded-xl" id="chart-traffic-raise" height="96" data-shadow="no"
                    data-type="line"></canvas>
          </div>
          <!-- /chart body -->

        </div>
        <!-- /chart card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-6">

        <!-- Card -->
        <div class="dt-card dt-card__full-height">

          <!-- Card Header -->
          <div class="dt-card__header">

            <!-- Card Heading -->
            <div class="dt-card__heading">
              <h3 class="dt-card__title">Your Portfolio Balance</h3>
            </div>
            <!-- /card heading -->

          </div>
          <!-- /card header -->

          <!-- Card Body -->
          <div class="dt-card__body">
            <!-- Grid -->
            <div class="row no-gutters">
              <!-- Grid Item -->
              <div class="col-sm-7 pr-sm-2 mb-6 mb-sm-0">
                <h2 class="display-2 font-weight-medium mb-3">
                  $179,626
                  <span class="d-inline-block f-14 text-success">64% <i class="icon icon-menu-up"></i></span>
                </h2>

                <span class="d-inline-block text-light-gray mb-6">Overall balance</span>

                <p class="card-text">
                  <a href="javascript:void(0)" class="btn btn-primary mr-2">Deposit</a>
                  <a href="javascript:void(0)" class="btn text-white bg-cyan">Withdraw</a>
                </p>

                <a href="javascript:void(0)" class="d-inline-block">
                  <i class="icon icon-add-circle mr-2"></i>Add New Wallet
                </a>
              </div>
              <!-- /grid item -->
              <!-- Grid Item -->
              <div class="col-sm-5">
                <h5 class="mb-4">Portfolio Distribution</h5>
                <ul class="dt-indicator">
                  <li class="dt-indicator-item">
                    <h5 class="dt-indicator-title f-12">BTC <span
                          class="d-inline-block border-left text-light-gray pl-2 ml-1">8.74</span></h5>
                    <div class="dt-indicator-item__info" data-fill="78" data-max="100" data-percent="true">
                      <div class="dt-indicator-item__fill bg-primary"></div>
                      <span class="dt-indicator-item__count ml-3">0</span>
                    </div>
                  </li>
                  <li class="dt-indicator-item">
                    <h5 class="dt-indicator-title f-12">RPL <span
                          class="d-inline-block border-left text-light-gray pl-2 ml-1">1.23</span></h5>
                    <div class="dt-indicator-item__info" data-fill="52" data-max="100" data-percent="true">
                      <div class="dt-indicator-item__fill bg-success"></div>
                      <span class="dt-indicator-item__count ml-3">0</span>
                    </div>
                  </li>
                  <li class="dt-indicator-item">
                    <h5 class="dt-indicator-title f-12">LTE <span
                          class="d-inline-block border-left text-light-gray pl-2 ml-1">0.71</span></h5>
                    <div class="dt-indicator-item__info" data-fill="18" data-max="100" data-percent="true">
                      <div class="dt-indicator-item__fill bg-warning"></div>
                      <span class="dt-indicator-item__count ml-3">0</span>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- /grid item -->
            </div>
            <!-- /grid -->
          </div>
          <!-- /card body -->

        </div>
        <!-- /card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-6">

        <!-- Card -->
        <div class="dt-card dt-card__full-height">

          <!-- Card Header -->
          <div class="dt-card__header">

            <!-- Card Heading -->
            <div class="dt-card__heading">
              <h3 class="dt-card__title">Balance History</h3>
            </div>
            <!-- /card heading -->

            <!-- Card Tools -->
            <div class="dt-card__tools">

              <!-- Dropdown -->
              <div class="dropdown d-inline-block">
                <a class="dropdown-toggle d-inline-block f-12 py-1 px-2 border rounded text-light-gray"
                   href="#"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                  Last 30 days
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript:void(0)">Last week</a>
                  <a class="dropdown-item" href="javascript:void(0)">Last 6 month</a>
                  <a class="dropdown-item" href="javascript:void(0)">Last 1 year</a>
                </div>
              </div>
              <!-- /dropdown -->

            </div>
            <!-- /card tools -->

          </div>
          <!-- /card header -->

          <!-- Chart Body -->
          <div class="dt-chart__body">
            <canvas height="100" id="chart-balance-history"></canvas>
          </div>
          <!-- /chart body -->

        </div>
        <!-- /card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-5 col-md-12">

        <!-- Card -->
        <div class="dt-card dt-card__full-height">

          <!-- Card Header -->
          <div class="dt-card__header">

            <!-- Card Heading -->
            <div class="dt-card__heading">
              <h3 class="dt-card__title">Send Money to</h3>
            </div>
            <!-- /card heading -->

            <!-- Card Tools -->
            <div class="dt-card__tools">
              <a href="javascript:void(0)" class="dt-card__more"><i class="icon icon-add-circle mr-2"></i>Add New
                Account</a>
            </div>
            <!-- /card tools -->

          </div>
          <!-- /card header -->

          <!-- Card Body -->
          <div class="dt-card__body pb-2">

            <!-- Campaigns Widget -->
            <div class="campaigns-widget">

              <!-- Grid -->
              <div class="row no-gutters pb-3 border-bottom">

                <!-- Grid Item -->
                <div class="col-6">
                  Account Holder Name
                </div>
                <!-- /grid item -->

                <!-- Grid Item -->
                <div class="col-3 text-right">
                  Last Transfer
                </div>
                <!-- /grid item -->

                <!-- Grid Item -->
                <div class="col-3 text-right">
                  ACTION
                </div>
                <!-- /grid item -->

              </div>
              <!-- /grid -->

              <!-- Widget -->
              <div class="dt-widget dt-widget-sm dt-widget-hover">

                <!-- Widget Item -->
                <div class="dt-widget__item">

                  <!-- Grid -->
                  <div class="row no-gutters">

                    <!-- Grid Item -->
                    <div class="col-6 pr-2">

                      <!-- Avatar Wrapper -->
                      <div class="dt-avatar-wrapper">
                        <!-- Avatar -->
                        <img class="dt-avatar size-30" src="assets/default/assets/images/user-avatar/nikki.jpg" alt="Mila Alba">
                        <!-- /avatar -->

                        <!-- Info -->
                        <div class="dt-avatar-info dt-widget__title">
                          <span class="dt-avatar-name">Mila Alba</span>
                        </div>
                        <!-- /info -->
                      </div>
                      <!-- /avatar wrapper -->
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <span class="mb-0 d-inline-block">2 hrs. ago</span>
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <a class="d-inline-block" href="javascript:void(0)"><i
                            class="icon icon-forward icon-fw mr-2"></i>Pay</a>
                    </div>
                    <!-- /grid item -->

                  </div>
                  <!-- /grid -->

                </div>
                <!-- /widgets item -->

                <!-- Widget Item -->
                <div class="dt-widget__item">

                  <!-- Grid -->
                  <div class="row no-gutters">

                    <!-- Grid Item -->
                    <div class="col-6 pr-2">

                      <!-- Avatar Wrapper -->
                      <div class="dt-avatar-wrapper">
                        <!-- Avatar -->
                        <img class="dt-avatar size-30" src="assets/default/assets/images/user-avatar/amay.jpg" alt="Dinesh Suthar">
                        <!-- /avatar -->

                        <!-- Info -->
                        <div class="dt-avatar-info dt-widget__title">
                          <span class="dt-avatar-name">Dinesh Suthar</span>
                        </div>
                        <!-- /info -->
                      </div>
                      <!-- /avatar wrapper -->
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <span class="mb-0 d-inline-block">17 days ago</span>
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <a class="d-inline-block" href="javascript:void(0)"><i
                            class="icon icon-forward icon-fw mr-2"></i>Pay</a>
                    </div>
                    <!-- /grid item -->

                  </div>
                  <!-- /grid -->

                </div>
                <!-- /widgets item -->

                <!-- Widget Item -->
                <div class="dt-widget__item">

                  <!-- Grid -->
                  <div class="row no-gutters">

                    <!-- Grid Item -->
                    <div class="col-6 pr-2">

                      <!-- Avatar Wrapper -->
                      <div class="dt-avatar-wrapper">
                        <!-- Avatar -->
                        <img class="dt-avatar size-30" src="assets/default/assets/images/user-avatar/garry-sobars.jpg"
                             alt="Pukhraj">
                        <!-- /avatar -->

                        <!-- Info -->
                        <div class="dt-avatar-info dt-widget__title">
                          <span class="dt-avatar-name">Pukhraj Prajapat</span>
                        </div>
                        <!-- /info -->
                      </div>
                      <!-- /avatar wrapper -->
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <span class="mb-0 d-inline-block">1 month ago</span>
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <a class="d-inline-block" href="javascript:void(0)"><i
                            class="icon icon-forward icon-fw mr-2"></i>Pay</a>
                    </div>
                    <!-- /grid item -->

                  </div>
                  <!-- /grid -->

                </div>
                <!-- /widgets item -->

                <!-- Widget Item -->
                <div class="dt-widget__item">

                  <!-- Grid -->
                  <div class="row no-gutters">

                    <!-- Grid Item -->
                    <div class="col-6 pr-2">

                      <!-- Avatar Wrapper -->
                      <div class="dt-avatar-wrapper">
                        <!-- Avatar -->
                        <img class="dt-avatar size-30" src="assets/default/assets/images/user-avatar/domnic-harris.jpg"
                             alt="crish Harris">
                        <!-- /avatar -->

                        <!-- Info -->
                        <div class="dt-avatar-info dt-widget__title">
                          <span class="dt-avatar-name">Chris Harris</span>
                        </div>
                        <!-- /info -->
                      </div>
                      <!-- /avatar wrapper -->
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <span class="mb-0 d-inline-block">1 month ago</span>
                    </div>
                    <!-- /grid item -->

                    <!-- Grid Item -->
                    <div class="col-3 d-flex align-items-center justify-content-end">
                      <a class="d-inline-block" href="javascript:void(0)"><i
                            class="icon icon-forward icon-fw mr-2"></i>Pay</a>
                    </div>
                    <!-- /grid item -->

                  </div>
                  <!-- /grid -->

                </div>
                <!-- /widgets item -->

              </div>
              <!-- /widget -->

            </div>
            <!-- /campaigns widget -->

          </div>
          <!-- /card body -->

        </div>
        <!-- /card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-3 col-md-6">

        <!-- Card -->
        <div class="dt-card dt-card__full-height bg-dark-primary text-white">

          <!-- Card Body -->
          <div class="dt-card__body text-center">

            <!-- Icon -->
            <i class="icon icon-refer icon-6x mb-5"></i>
            <!-- /icon -->

            <h3 class="text-white">Refer and Get Reward</h3>

            <p class="card-text">Reffer us to your friends and earn bonus when they join.</p>
            <a class="btn btn-secondary text-white" href="javascript:void(0)">Invite Friends</a>

          </div>
          <!-- /card body -->

        </div>
        <!-- /card -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-4 col-md-6">

        <!-- Card -->
        <div class="dt-card dt-card__full-height">

          <!-- Card Header -->
          <div class="dt-card__header mb-4">

            <!-- Card Heading -->
            <div class="dt-card__heading">
              <h3 class="dt-card__title">Currency Calculator</h3>
            </div>
            <!-- /card heading -->

          </div>
          <!-- /card header -->

          <!-- Card Body -->
          <div class="dt-card__body">

            <span class="d-block mb-2">1.87 BTC equals</span>
            <h2 class="mb-2 display-4 font-weight-medium text-primary">11466.78 USD</h2>
            <span class="d-block mb-6 f-12">@ 1 BTC = 6718.72 USD</span>

            <!-- Form -->
            <form>
              <div class="form-row mb-4">
                <div class="col-sm-4 col-6">
                  <label for="currency-type-1">From</label>
                  <select class="custom-select custom-select-sm" id="currency-type-1">
                    <option selected>BTC</option>
                    <option value="1">RPL</option>
                    <option value="2">LTE</option>
                  </select>
                </div>
                <div class="col-sm-4 col-6">
                  <label for="currency-type">From</label>
                  <select class="custom-select custom-select-sm" id="currency-type">
                    <option selected>USD</option>
                    <option value="1">Yen</option>
                    <option value="2">Dinar</option>
                  </select>
                </div>
                <div class="col-sm-4 col-12 mt-5 mt-sm-0">
                  <label for="amount">Amount(BTC)</label>
                  <input type="text" class="form-control form-control-sm" id="amount" placeholder="Amount">
                </div>
              </div>
              <button class="btn btn-primary" type="submit">Transfer Now</button>
            </form>
            <!-- /form -->

          </div>
          <!-- /card body -->

        </div>
        <!-- /card -->

      </div>
      <!-- /grid item -->

    </div>
    <!-- /grid -->

    <!-- Grid -->
    <div class="row">

      <!-- Grid Item -->
      <div class="col-xl-4 order-xl-2">

        <!-- Grid -->
        <div class="row">
          <!-- Grid Item -->
          <div class="col-xl-12">

            <!-- Card -->
            <div class="dt-card dt-card__full-height bg-image">

              <!-- Card Body -->
              <div class="dt-card__body bg-gradient-dark-purple">

                <!-- Grid -->
                <div class="row">

                  <!-- Grid Item -->
                  <div class="col-xl-8">
                    <p class="mb-2">Download Mobile Apps</p>
                    <p class="mb-xl-0 display-5 font-weight-medium">Now, your account is on your fingers</p>
                  </div>
                  <!-- /grid item -->

                  <!-- Grid Item -->
                  <div class="col-xl-4">
                    <a href="javascript:void(0)" class="d-inline-block mb-2">
                      <img src="assets/default/assets/images/dashboard/google-play-store.png" alt="Play Store" class="img-fluid">
                    </a> <a href="javascript:void(0)" class="d-inline-block">
                      <img src="assets/default/assets/images/dashboard/apple-app-store.png" alt="App Store" class="img-fluid"> </a>
                  </div>
                  <!-- /grid item -->

                </div>
                <!-- /grid -->
              </div>
              <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->

          <!-- Grid Item -->
          <div class="col-xl-12">

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Header -->
              <div class="dt-card__header">

                <!-- Card Heading -->
                <div class="dt-card__heading">
                  <h3 class="dt-card__title">Order History</h3>
                </div>
                <!-- /card heading -->

                <!-- Card Tools -->
                <div class="dt-card__tools">
                  <a href="javascript:void(0)" class="dt-card__more">Detailed History</a>
                </div>
                <!-- /card tools -->

              </div>
              <!-- /card header -->

              <!-- Card Body -->
              <div class="dt-card__body pb-5">

                <!-- Tables -->
                <div class="table-responsive ps-custom-scrollbar">
                  <table class="table table-ordered table-bordered-0 mb-0">
                    <thead>
                    <tr>
                      <th class="text-uppercase">Currency</th>
                      <th class="text-uppercase text-right" scope="col">Rate (USD)</th>
                      <th class="text-uppercase text-center" scope="col">Date</th>
                      <th class="text-uppercase text-right" scope="col">Fee</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>0.24 BTC</td>
                      <td class="text-right text-nowrap">1 BTC = $740</td>
                      <td class="text-center">08.10.17</td>
                      <td class="text-right text-danger">-$2.33</td>
                    </tr>
                    <tr>
                      <td>0.32 RPL</td>
                      <td class="text-right text-nowrap">1 RPL = $80.2</td>
                      <td class="text-center">08.03.17</td>
                      <td class="text-right text-danger">-$1.23</td>
                    </tr>
                    <tr>
                      <td>0.24 BTC</td>
                      <td class="text-right text-nowrap">1 BTC = $740</td>
                      <td class="text-center">07.29.17</td>
                      <td class="text-right text-danger">-$3.22</td>
                    </tr>
                    <tr>
                      <td>0.22 BTC</td>
                      <td class="text-right text-nowrap">1 BTC = $740</td>
                      <td class="text-center">07.28.17</td>
                      <td class="text-right text-danger">-$3.22</td>
                    </tr>
                    <tr>
                      <td>0.74 LTE</td>
                      <td class="text-right text-nowrap">1 LTE = $99.9</td>
                      <td class="text-center">05.22.17</td>
                      <td class="text-right text-danger">-$2.21</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /tables -->

              </div>
              <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->
        </div>
        <!-- /grid -->

      </div>
      <!-- /grid item -->

      <!-- Grid Item -->
      <div class="col-xl-8 order-xl-1">

        <!-- Card -->
        <div class="dt-card dt-card__full-height">

          <!-- Card Header -->
          <div class="dt-card__header">

            <!-- Card Heading -->
            <div class="dt-card__heading order-sm-1 flex-initial">
              <h3 class="dt-card__title">Crypto News</h3>
            </div>
            <!-- /card heading -->

            <!-- Card Tools -->
            <div class="dt-card__tools order-sm-3">
              <a href="javascript:void(0)" class="dt-card__more">
                <i class="icon icon-search-new icon-xl"></i>
              </a>
            </div>
            <!-- /card tools -->

            <!-- Menu -->
            <ul class="nav nav-pills nav-pills-sm order-sm-2">
              <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0)">All</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">Bitcoin</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">Ripple</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">Litecoin</a>
              </li>
            </ul>
            <!-- /menu -->

          </div>
          <!-- /card header -->

          <!-- Card Body -->
          <div class="dt-card__body">

            <!-- Media List -->
            <div class="media-list">
              <!-- Media -->
              <div class="media media-news">

                <!-- Image -->
                <img class="img-fluid rounded-xl" src="assets/default/assets/images/dashboard/bitcoin-cryptocurrency-trader.jpg"
                     alt="Crypto Currency">
                <!-- /image -->

                <!-- Media Body -->
                <div class="media-body">
                  <h4 class="mb-2">10 things you must know before trading in cryptocurrency</h4>
                  <p>
                    Cras tincidunt sit amet massa at accumsan. Mauris tincidunt tincidunt est, et pulvinar
                    felis pharetra in vestibulum sed.
                  </p>
                  <div class="d-flex flex-wrap">
                    <p class="mb-0 text-light-gray flex-1 text-truncate">
                      <i class="icon icon-tag-new icon-lg mr-2 align-top"></i>
                      BTC, Crypto, Trading, Tips, Cryptocurrency
                    </p>
                    <a class="d-inline-block ml-auto" href="javascript:void(0)"><span>Ready Full Story</span><i
                          class="icon icon-long-arrow-right icon-lg ml-2"></i></a>
                  </div>
                </div>
                <!-- /media body -->

              </div>
              <!-- /media -->
              <!-- Media -->
              <div class="media media-news">

                <!-- Image -->
                <img class="img-fluid rounded-xl" src="assets/default/assets/images/dashboard/bitcoin-in-the-mousetrap.jpg"
                     alt="Crypto Currency">
                <!-- /image -->

                <!-- Media Body -->
                <div class="media-body">
                  <h4 class="mb-2">Getting started with cryptocurrency - what is blockchain</h4>
                  <p>
                    Cras tincidunt sit amet massa at accumsan. Mauris tincidunt tincidunt est, et pulvinar
                    felis pharetra in vestibulum sed.
                  </p>
                  <div class="d-flex flex-wrap">
                    <p class="mb-0 text-light-gray flex-1 text-truncate">
                      <i class="icon icon-tag-new icon-lg mr-2 align-top"></i>
                      Blockchain, tutorial, Cryptocurrency
                    </p>
                    <a class="d-inline-block ml-auto" href="javascript:void(0)"><span>Ready Full Story</span><i
                          class="icon icon-long-arrow-right icon-lg ml-2"></i></a>
                  </div>
                </div>
                <!-- /media body -->

              </div>
              <!-- /media -->
              <!-- Media -->
              <div class="media media-news">

                <!-- Image -->
                <img class="img-fluid rounded-xl" src="assets/default/assets/images/dashboard/concept-of-blockchain.jpg"
                     alt="Block Chain">
                <!-- /image -->

                <!-- Media Body -->
                <div class="media-body">
                  <h4 class="mb-2">Is cryptocurrency investment a trap or opportunity?</h4>
                  <p>
                    Cras tincidunt sit amet massa at accumsan. Mauris tincidunt tincidunt est, et pulvinar
                    felis pharetra in vestibulum sed.
                  </p>
                  <div class="d-flex flex-wrap">
                    <p class="mb-0 text-light-gray flex-1 text-truncate">
                      <i class="icon icon-tag-new icon-lg mr-2 align-top"></i>
                      Blockchain, tips, Cryptocurrency
                    </p>
                    <a class="d-inline-block ml-auto" href="javascript:void(0)"><span>Ready Full Story</span><i
                          class="icon icon-long-arrow-right icon-lg ml-2"></i></a>
                  </div>
                </div>
                <!-- /media body -->

              </div>
              <!-- /media -->
            </div>
            <!-- /media list -->

          </div>
          <!-- /card body -->

        </div>
        <!-- /card -->

      </div>
      <!-- /grid item -->

    </div>
    <!-- /grid -->

  </div>
@endsection
