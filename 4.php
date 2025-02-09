<?php

  /**
   * 231232028 - Falmesino Abdul Hamid
   * Fungsi detectAnomaliesEMA menghitung Exponential Moving Average (EMA)
   * dan mendeteksi anomali jika nilai sensor menyimpang terlalu jauh dari EMA.
   */

  function detectAnomaliesEMA($data, $alpha = 0.2, $threshold = 2.0) {
    $ema = $data[0]; // Inisialisasi dengan data pertama
    $anomalies = [];
    $emaValues = [$ema];

    // Hitung EMA untuk setiap data
    for ($i = 1; $i < count($data); $i++) {
      $ema = $alpha * $data[$i] + (1 - $alpha) * $ema;
      $emaValues[] = $ema;
    }

    // Hitung rata-rata deviasi absolut antara data dan EMA
    $sumDiff = 0;
    foreach ($data as $i => $value) {
      $sumDiff += abs($value - $emaValues[$i]);
    }
    $meanDiff = $sumDiff / count($data);

    // Deteksi anomali: jika selisih absolut melebihi threshold * meanDiff
    foreach ($data as $i => $value) {
      if (abs($value - $emaValues[$i]) > $threshold * $meanDiff) {
        $anomalies[$i] = $value;
      }
    }
    return $anomalies;
  }

  // Data sensor (misalnya, suhu) secara real-time.
  $sensorData = [22.5, 22.7, 22.6, 22.8, 23.0, 23.1, 22.9, 23.2, 25.0, 23.0, 22.8, 22.7, 22.5];

  $anomalies = detectAnomaliesEMA($sensorData, 0.3, 2.0);

  echo "Data Sensor:\n";
  print_r($sensorData);
  echo "\nAnomali Teridentifikasi (indeks => nilai):\n";
  print_r($anomalies);
?>