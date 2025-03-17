@extends('layouts.app3')
@section('content')
<section class="admin-page">
  <div class="title">
    <h2>Thống kê</h2>
    <a href="{{  route('export-orders') }}" ><button class="add-btn">Xuất excel</button></a>
  </div>
  <div class="grid">
    <div class="chart">
      <h3>Doanh số và tổng sản phẩm bán được</h3>
      <canvas id="total-chart"></canvas>
    </div>
    <div class="top-sell">
      <h3>Top 5 sản phẩm bán chạy</h3>
      <div id="top-sell-board">
      </div>
    </div>
    <div class="total" id="sales">
      <div><i class="fa-solid fa-wallet"></i></div>
      <h3 id="total-sales"></h3>
    </div>
    <div class="total" id="sold">
      <div><i class="fa-solid fa-cart-shopping"></i></div>
      <h3 id="total-sold"></h3>
    </div>
    <div class="total" id="cus">
      <div><i class="fa-solid fa-user"></i></div>
      <h3 id="total-cus"></h3>
    </div>
  </div>
</section>

<script src="/chart.js"></script>
<script src="/jquery.js"></script>
<script>
  $(document).ready(function () {
        $.ajax({
            url: 'home/getInfo/', 
            type: 'GET',
            dataType: 'json',
            success: function (data) {
              const topSellTable = document.getElementById('top-sell-board');
              topSellTable.innerHTML = '';
              data.topProducts.forEach(function (product) {
                  var row = document.createElement('ul');
                  row.innerHTML = `
                      <li><img src="{{ URL('image/product-image/') }}/${product.img}">
                      <p class="pro-name">${product.name}</p>
                      <p class="pro-pri">${Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</p>
                      <p class="pro-sold">Đã bán ${product.total_quantity}</p>
                      </li>
                  `;
                  topSellTable.appendChild(row);
              });
              $('#total-sales').text('Tổng doanh số trong tháng: ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.totalSalesInMonth));
              $('#total-sold').text('Tổng sản phẩm bán trong tháng: '+ data.totalSoldInMonth);
              $('#total-cus').text('Khách hàng: ' + data.totalCustomers);
              const ctx = document.getElementById('total-chart');
              var chartData = {
                    labels: Object.keys(data.dailySoldData),
                    datasets: [
                        {
                            label: "Số sản phẩm bán được",
                            data: Object.values(data.dailySoldData),
                            borderColor: 'rgba(192, 75, 75, 1)',
                            yAxisID: 'y',
                            tension: 0.3
                        },
                        {
                            label: "Doanh só bán hàng",
                            data: Object.values(data.dailySalesData),
                            borderColor: '#076AE1',
                            yAxisID: 'y1',
                            tension: 0.3
                        }
                    ]
                };
                new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Biểu đồ doanh số bán hàng hàng tháng'
                        },
                        scales: {
                            x: {
                                display: true,
                                grid: { display: false },
                            },
                            y: {
                                display: true,
                                beginAtZero: true,
                                grid: { display: false },
                                title: { display: true, text: 'Số lượng sản phẩm'}
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                beginAtZero: true,
                                position: 'right',
                                grid: { drawOnChartArea: false },
                                title: {display: true, text: 'Doanh số'}
                            },
                        }
                    }
                });
            }
        });
    });
</script>


@endsection