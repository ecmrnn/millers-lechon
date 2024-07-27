<?php 
    $ulams = [
        ["ulam" => "Sinigang (Baboy)", "price" => 120],
        ["ulam" => "Lechon Sisig", "price" => 120],
        ["ulam" => "Dinuguan", "price" => 80],
        ["ulam" => "Chopsuey", "price" => 60],
        ["ulam" => "Ampalaya", "price" => 50],
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miller's Lechon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js" defer></script>
</head>
<body class="max-w-md mx-auto text-slate-800">
    <main class="py-10">
        <h1 class="font-bold text-3xl">Miller's Lechon Menu</h1>

        <form class="space-y-5 mt-5">
            <textarea name="output" id="output" class="px-3 py-2 block w-full border border-slate-200 rounded-md min-h-52"></textarea>
            <button id="copy" type="button" class="bg-green-800 px-3 py-2 rounded-md text-white font-semibold w-full">Copy Text</button>

            <p class="font-semibold">Pili ka ng mga pagkain na nasa menu for today...</p>

            <div class="grid gap-2">
                
                <?php foreach ($ulams as $ulam) : ?>
                    <label for="<?= $ulam["ulam"] ?>" class="ulam-label select-none flex items-center gap-5">
                        <input type="checkbox" name="ulam" id="<?= $ulam["ulam"] ?>">
                        <p class="capitalize"><strong class="ulam-name"><?= $ulam["ulam"] ?></strong> - <span><?= number_format($ulam["price"], 2) ?></span></p>
                    </label>
                <?php endforeach ?>
            </div>
        </form>
    </main>
</body>
</html>