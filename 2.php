<?php

  // 231232028 - Falmesino Abdul Hamid
  // Data transaksi: setiap transaksi terdiri atas kategori dan nilai penjualan

  $transactions = [
    ['kategori' => 'Elektronik', 'nilai' => 100],
    ['kategori' => 'Pakaian', 'nilai' => 50],
    ['kategori' => 'Elektronik', 'nilai' => 200],
    ['kategori' => 'Makanan', 'nilai' => 30],
    ['kategori' => 'Pakaian', 'nilai' => 70],
    ['kategori' => 'Makanan', 'nilai' => 45]
  ];

  // Fungsi Mapper: mengelompokan data berdasarkan kategori
  function mapper($transactions) {
    $mapped = [];
    foreach ($transactions as $trans) {
      $key = $trans['kategori'];
      $value = $trans['nilai'];
      if(!isset($mapped[$key])) {
        $mapped[$key] = [];
      }
      $mapped[$key][] = $value;
    }
    return $mapped;
  }

  // Fungsi Reducer: menjumlahkan nilai penjualan untuk setiap kategori
  function reducer($mappedData) {
    $reduced = [];
    foreach ($mappedData as $key => $values) {
      $reduced[$key] = array_sum($values);
    }
    return $reduced;
  }

  $mappedData = mapper($transactions);
  $reducedData = reducer($mappedData);

  echo "Total Penjualan per Kategori:\n";
  foreach ($reducedData as $kategori => $total) {
    echo $kategori . ": " . $total . "\n";
  }

?>