<?php
class RankingTable {
    private $players;
    private $scores;

    public function __construct(array $players) {
        $this->players = $players;
        $this->scores = array_fill_keys($players, []);
    }

    public function recordResult(string $player, int $score) {
        if (!isset($this->scores[$player])) {
            return;
        }
        $this->scores[$player][] = $score;
    }

    public function playerRank(int $rank): ?string {
        $ranking = array_map(function ($player) {
            return [
                'name' => $player,
                'score' => array_sum($this->scores[$player]),
                'games' => count($this->scores[$player]),
            ];
        }, $this->players);

        usort($ranking, function ($a, $b) {
            if ($a['score'] != $b['score']) {
                return $b['score'] - $a['score'];
            }

            if ($a['games'] != $b['games']) {
                return $a['games'] - $b['games'];
            }

            return array_search($a['name'], $this->players) - array_search($b['name'], $this->players);
        });

        return $ranking[$rank - 1]['name'] ?? null;
    }
}
$table = new RankingTable(['Jan', 'Maks', 'Monika']);
$table->recordResult('Jan', 2);
$table->recordResult('Maks', 3);
$table->recordResult('Monika', 5);
echo $table->playerRank(1); // "Monika"

?>
