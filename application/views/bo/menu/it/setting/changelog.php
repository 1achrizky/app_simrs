
<?php
$clog = [
  [
    "release_date" => "2020-05-28",
    "list" => [
      "general_changes" => [],
      "bug_fixes" => [
        "Pendaftaran Booking. Saat ENTER norm, filter norm harus tanpa ada flag=0. Menambahkan tanggal saat flag=0 pada alert.",
      ],
    ],
  ],
  [
    "release_date" => "2020-06-04",
    "list" => [
      "general_changes" => [],
      "bug_fixes" => [
        "Penambahan menu SETTING PRINTER.",
      ],
    ],
  ],
];
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">CHANGE LOG</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <?= "<pre>",print_r($clog),"</pre>" ;?>
        </div>
      </div>
        
    </section>
  </div>