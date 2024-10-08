       <main class="row container-fluid m-0 p-0">
           <?php require_once __DIR__ . "/../Component/sidebar.php" ?>

           <section class="col bg-light">
               <div class="container-fluid p-0">
                   <section class="d-flex gap-2">
                       <div class="card flex-fill">
                           <div class="card-body row align-items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#06D6A0" class="col-4 bi bi-people" viewBox="0 0 16 16">
                                   <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                               </svg>
                               <span class="col-8 d-flex flex-column">
                                   <span>Jumlah Peserta</span>
                                   <span><b><?= $model["statistics"]["total_peserta"] ?></b></span>
                               </span>
                           </div>
                       </div>
                       <div class="card flex-fill">
                           <div class="card-body row align-items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#0d6efd" class="col-4 bi bi-person-standing" viewBox="0 0 16 16">
                                   <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0" />
                               </svg>
                               <span class="col-8 d-flex flex-column">
                                   <span>Jumlah Laki-Laki</span>
                                   <span><b><?= $model["statistics"]["total_laki_laki"] ?></b></span>
                               </span>
                           </div>
                       </div>
                       <div class="card flex-fill">
                           <div class="card-body row align-items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#EF476F" class="col-4 bi bi-people" viewBox="0 0 16 16">
                                   <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m-.5 12.25V12h1v3.25a.75.75 0 0 0 1.5 0V12h1l-1-5v-.215a.285.285 0 0 1 .56-.078l.793 2.777a.711.711 0 1 0 1.364-.405l-1.065-3.461A3 3 0 0 0 8.784 3.5H7.216a3 3 0 0 0-2.868 2.118L3.283 9.079a.711.711 0 1 0 1.365.405l.793-2.777a.285.285 0 0 1 .56.078V7l-1 5h1v3.25a.75.75 0 0 0 1.5 0Z" />

                               </svg>
                               <span class="col-8 d-flex flex-column">
                                   <span>Jumlah Perempuan</span>
                                   <span><b><?= $model["statistics"]["total_perempuan"] ?></b></span>
                               </span>
                           </div>
                       </div>
                       <div class="card flex-fill">
                           <div class="card-body row align-items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#FFD166" class="col-4 bi bi-people" viewBox="0 0 16 16">
                                   <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                               </svg>
                               <span class="col-8 d-flex flex-column">
                                   <span>Rata-Rata Umur</span>
                                   <span><b><?= round($model["statistics"]["rata_rata_usia"], 2) ?></b></span>
                               </span>
                           </div>
                       </div>
                   </section>

                   <section class="d-flex gap-2">
                       <div class="card p-4">
                           <canvas id="chartDoughnut"></canvas>
                       </div>
                       <div class="card p-4 flex-fill">
                           <span>Total Dosis 1</span>
                           <h1><?= $model["statistics"]["total_dosis_1"] ?></h1>
                           <span>Total Dosis 2</span>
                           <h1><?= $model["statistics"]["total_dosis_2"] ?></h1>
                           <span>Total Dosis 3</span>
                           <h1><?= $model["statistics"]["total_dosis_3"] ?></h1>
                       </div>
                   </section>
               </div>
           </section>
       </main>

       <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
       <script>
           const chartDoughnut = document.getElementById('chartDoughnut');

           const statistics = {
               dosis1: <?= $model["statistics"]["total_dosis_1"] ?>,
               dosis2: <?= $model["statistics"]["total_dosis_2"] ?>,
               dosis3: <?= $model["statistics"]["total_dosis_3"] ?>
           };

           const dataDoughnut = {
               labels: [
                   'Dosis 1',
                   'Dosis 2',
                   'Dosis 3'
               ],
               datasets: [{
                   data: [statistics.dosis1, statistics.dosis2, statistics.dosis3],
                   backgroundColor: [
                       'rgb(255, 99, 132)',
                       'rgb(54, 162, 235)',
                       'rgb(255, 205, 86)'
                   ]
               }]
           };

           new Chart(chartDoughnut, {
               type: 'doughnut',
               data: dataDoughnut,
               options: {
                   plugins: {
                       legend: {
                           display: true,
                           position: 'bottom',
                           labels: {
                               usePointStyle: true,
                               pointStyle: 'circle'
                           }
                       }
                   }
               }
           });
       </script>