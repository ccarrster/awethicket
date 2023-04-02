<?php



if(isset($_GET['action'])){
    $action = $_GET['action'];
} else {
    echo('Supported Actions: createGame, showGames, loadGame, joinGame');
    die();
}

if($action == 'createGame'){
    $gameId = uniqid();
    file_put_contents('games/'.$gameId.'.txt', serialize(getNewGame()));
} elseif($action == 'showGames'){
    $allFiles = scandir('games');
    $files = array_diff($allFiles, array('.', '..'));
    var_dump($files);
} elseif($action == 'loadGame'){
    if(isset($_GET['gameId'])){
        $gameId = $_GET['gameId'];
        $gameString = file_get_contents('games/'.$gameId.'.txt');
        var_dump(unserialize($gameString));
    } else {
        echo('gameId required');
    }
} elseif($action == 'joinGame'){
    if(isset($_GET['gameId'])){
        $gameId = $_GET['gameId'];
        $gameString = file_get_contents('games/'.$gameId.'.txt');
        $game = unserialize($gameString);
        $playerId = uniqid();
        $player = [
            "id" => $playerId,
            "availableCrates" => null,
            "maxAvailableCrates" => null,
            "mushrooms" => [0, 0, 0, 0],
            "informationPieces" => [],
            "points" => 0,
            "skipped" => null
        ];
        $game['players'][] = $player;
        file_put_contents('games/'.$gameId.'.txt', serialize($game));
        echo($playerId);
    } else {
        echo('gameId required');
    }
}

$crateNumbers = [1, 2, 3, 4, 4];
$mushroomNames = ['Girolles', 'Morels', 'Boletes', 'Parasol'];
$playerColors = ['Blue', 'Green', 'Purple', 'Red', 'Orange'];
$scores = [1, 3, 5, 7];
//These are just globals copied over, some may be UI only
//Some others are likely needed for state

function getNewGame(){
    $game = ["firstPlayer" => null,
        "mushroomBoards" => [],
        "players" => [],
        "currentPlayer" => null,
        "informationFlipDeck" => [],
        "winners" => [],
        "startSharePlayer" => null, //This may be redundant
        "gameOver" => false,
        "inShareMode" => false,
        "mushroomBonusIndex" => 0
    ];
    return $game;
}
?>