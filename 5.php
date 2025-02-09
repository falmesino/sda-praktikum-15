<?php

  /**
   * 231232028 - Falmesino Abdul Hamid
   */

  class Node {
    public $x;
    public $y;
    public $g; // biaya dari start ke node ini
    public $h; // esitmasi biaya dari node ini ke goal (heuristik)
    public $f; // total biaya (g + h)
    public $parent;

    public function __construct($x, $y, $g = 0, $h = 0, $parent = null) {
      $this->x = $x;
      $this->y = $y;
      $this->g = $g;
      $this->h = $h;
      $this->f = $g + $h;
      $this->parent = $parent;
    }
  }

  // Fungsi heuristic: menggunakan jarak Manhattan
  function heuristic($node, $goal) {
    return abs($node->x - $goal->x) + abs($node->y - $goal->y);
  }

  // Fungsi untuk mendapatkan tetangga (4 arah: atas, kanan, bawah, kiri)
  function getNeighbors($node, $grid) {
    $neighbors = [];
    $directions = [[0, 1], [1, 0], [0, -1], [-1, 0]];
    foreach ($directions as $d) {
      $nx = $node->x + $d[0];
      $ny = $node->y + $d[1];
      if (isset($grid[$ny][$nx]) && $grid[$ny][$nx] == 0) {
        // 0 = jalan bebas
        $neighbors[] = new Node($nx, $ny);
      }
    }
    return $neighbors;
  }

  function aStar($grid, $start, $goal) {
    $openSet = [];
    $closedSet = [];
    $startNode = new Node($start[0], $start[1]);
    $startNode->h = heuristic($startNode, new Node($goal[0], $goal[1]));
    $startNode->f = $startNode->g + $startNode->h;
    $openSet[] = $startNode;

    while (!empty($openSet)) {
      // Pilih node dengan f terkecil
      usort($openSet, function($a, $b) {
        return $a->f <=> $b->f;
      });
      $current = array_shift($openSet);

      // Jika mencapai tujuan, rekonstruksi jalur
      if ($current->x == $goal[0] && $current->y == $goal[1]) {
        $path = [];
        while ($current != null) {
          $path[] = [$current->x, $current->y];
          $current = $current->parent;
        }
        return array_reverse($path);
      }

      $closedSet[] = $current;
      foreach (getNeighbors($current, $grid) as $neighbor) {
        // Lewati jika neighbor sudahh ada di closedSet
        $skip = false;
        foreach ($closedSet as $closed) {
          if ($closed->x == $neighbor->x && $closed->y == $neighbor->y) {
            $skip = true;
            break;
          }
        }
        if ($skip) continue;

        $tentative_g = $current->g + 1; // asumsi jarak antar tetangga = 1

        // Periksa apakah neighbor sudah ada di openSet dengan nilai g lebih rendah
        $inOpen = false;
        foreach ($openSet as $node) {
          if ($node->x == $neighbor->x && $node->y == $neighbor->y) {
            $inOpen = true;
            if ($tentative_g >= $node->g) {
              $skip = true;
            }
            break;
          }
        }
        if ($skip) continue;

        $neighbor->g = $tentative_g;
        $neighbor->h = heuristic($neighbor, new Node($goal[0], $goal[1]));
        $neighbor->f = $neighbor->g + $neighbor->h;
        $neighbor->parent = $current;
        $openSet[] = $neighbor;
      }
    }
    return null; // Jalur tidak ditemukan
  }

  // Contoh grid (0 = jalan bebas, 1 = rintangan)
  $grid = [
    [0, 0, 0, 0, 0],
    [0, 1, 1, 1, 0],
    [0, 0, 0, 1, 0],
    [0, 1, 0, 0, 0],
    [0, 0, 0, 1, 0]
  ];
  $start = [0, 0];
  $goal = [4, 4];

  $path = aStar($grid, $start, $goal);

  if ($path) {
    echo "Jalur ditemukan:\n";
    foreach ($path as $p) {
      echo "(" . $p[0] . ", " . $p[1] . ")";
    }
    echo "\n";
  } else {
    echo "Jalur tidak ditemukan.\n";
  }

?>