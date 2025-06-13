<?php
// 📌 Eerst ALLE klassen inladen
include("./src/Cube.php");
include("./src/CubeList.php");
include("./src/Game.php");
include("./src/GameList.php");
include("./src/Hint.php");
include("./src/HintList.php");
include("./src/Turn.php");
include("./src/TurnList.php");
include("./src/Play.php");

// 📌 Daarna pas sessie starten!
session_start();
?>
<!doctype html>
<html lang="nl" class="h-100">
<head>
    <meta charset="utf-8">
    <title>Wakken, IJsberen en Pinguïns</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>main > .container { padding: 60px 15px 0; }</style>
</head>
<body class="d-flex flex-column h-100">

<header class="bg-dark text-white py-2">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4 m-0">Wakken, IJsberen en Pinguïns</h1>
        <form method="post">
            <button type="submit" name="newGame" value="1" class="btn btn-light">Start nieuw spel</button>
        </form>
    </div>
</header>

<main class="flex-shrink-0">
    <div class="container">
        <div class="alert alert-info mt-3">
            Raad het aantal wakken, ijsberen en pinguïns. Je krijgt een hint na 3 fouten. Je kunt ook het antwoord opvragen.
        </div>

<?php
// 📌 NIEUW SPEL starten
if (isset($_POST['newGame'])) {
    if (isset($_SESSION['play'])) {
        $_SESSION['play']->reset();
    }
    $_SESSION['play'] = new Play();
    unset($_SESSION['status']);
}

// 📌 SPEL BESTAAT
if (isset($_SESSION['play'])) {
    $play = $_SESSION['play'];

    // 📌 SPELERNAAM INVULLEN
    if (isset($_POST['newPlay']) && !empty($_POST['name'])) {
        $play->setPlayerName($_POST['name']);
    }

    // 📌 NAAM nog niet ingevuld → vraag naam
    if (empty($play->getPlayerName())) {
?>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Naam speler</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" name="newPlay" class="btn btn-primary">Doorgaan</button>
    </form>
<?php
        return;
    }

    // 📌 DOBBELSTENEN KIEZEN
    if (isset($_POST['cubes']) && is_numeric($_POST['cubes'])) {
        $game = new Game((int)$_POST['cubes']);
        $play->addGame($game);
    }

    // 📌 GOKKEN
    if (isset($_POST['guess']) && is_numeric($_POST['iceholes']) && is_numeric($_POST['polarbears']) && is_numeric($_POST['penguins'])) {
        $play->addGuess($_POST['iceholes'], $_POST['polarbears'], $_POST['penguins']);
        echo "<div class='alert alert-warning'>" . $play->checkScore() . "</div>";
    }

    // 📌 ANTWOORD LATEN ZIEN
    if (isset($_POST['answer'])) {
        $play->draw();
        $a = $play->getAnswer();
        echo "<div class='alert alert-success'><strong>Antwoord:</strong> Wakken: $a[0], IJsberen: $a[1], Pinguïns: $a[2]</div>";
    }

    // 📌 STATUS bepalen
    $status = $_SESSION['status'] ?? null;

    if ($status === 'start' || $status === 'wrong') {
        if ($status === 'wrong' && ($_SESSION['wrong'] ?? 0) % 3 === 0) {
            echo "<div class='alert alert-info'>Hint: " . $play->getHint() . "</div>";
        }

        $play->draw();
?>
    <form method="post" class="mt-3">
        <div class="mb-2">
            <label>Raad Wakken:
                <input type="number" name="iceholes" required class="form-control">
            </label>
        </div>
        <div class="mb-2">
            <label>Raad IJsberen:
                <input type="number" name="polarbears" required class="form-control">
            </label>
        </div>
        <div class="mb-2">
            <label>Raad Pinguïns:
                <input type="number" name="penguins" required class="form-control">
            </label>
        </div>
        <button type="submit" name="guess" class="btn btn-success">Raad</button>
        <button type="submit" name="answer" class="btn btn-secondary">Toon Antwoord</button>
    </form>
<?php
    } elseif ($status === 'correct' || $status === 'answer' || $status === null) {
?>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label>Kies aantal dobbelstenen (3–8):
                <input type="number" name="cubes" min="3" max="8" required class="form-control">
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Gooien</button>
    </form>
<?php
    }

    // 📌 OVERZICHT GAMES
    echo "<hr><h4>Vorige Games</h4><ul class='list-group mb-3'>";
    foreach ($play->getPreviousGames() as $g) {
        echo "<li class='list-group-item'>Beurten: " . $g->getGameTurns() . ", Fouten: " . $g->getWrongAnswers() . "</li>";
    }
    echo "</ul><p><strong>Totaalscore: " . $play->getScore() . "</strong></p>";

} else {
?>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Naam speler</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" name="newPlay" class="btn btn-primary">Start spel</button>
    </form>
<?php } ?>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">© <?php echo date('Y'); ?> Wakken & IJsberen</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
