<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <style>
            td {
                padding: 2px 10px;
                margin: 0;
            }

            tr:nth-child(odd) {
                background-color: #eee;
            }
        </style>
    </head>
    <body>
        <!-- <table>
            @foreach ($answers as $answer)
                <tr>
                    <td>{{ $answer->id }}</td>
                    <td>{{ $answer->image }}</td>
                    <td>{{ $answer->answer }}</td>
                    <td>{{ $answer->subject }}</td>
                </tr>
            @endforeach
        </table> -->

        <?php
            $categories = ['bad' => 1, 'poor' => 2, 'fair' => 3, 'good' => 4, 'excellent' => 5];

    $images = [
        'final01_d2_l1' => 1,
        'final01_d2_l2' => 2,
        'final01_d2_l3' => 3,
        'final01_d2_l4' => 4,
        'final01_d2_l5' => 5,
        // two circle lamps
        'final02_d2_l1' => 6,
        'final02_d2_l2' => 7,
        'final02_d2_l3' => 8,
        'final02_d2_l4' => 9,
        'final02_d2_l5' => 10,
        // red winter barn
        'final07_d2_l1' => 11,
        'final07_d2_l2' => 12,
        'final07_d2_l3' => 13,
        'final07_d2_l4' => 14,
        'final07_d2_l5' => 15,
        // food
        'final20_d2_l1' => 1,
        'final20_d2_l2' => 1,
        'final20_d2_l3' => 1,
        'final20_d2_l4' => 1,
        'final20_d2_l5' => 1,
        // sunflower
        'final16_d2_l1' => 1,
        'final16_d2_l2' => 1,
        'final16_d2_l3' => 1,
        'final16_d2_l4' => 1,
        'final16_d2_l5' => 1,
        // peacock
        'final09_d2_l1' => 1,
        'final09_d2_l2' => 1,
        'final09_d2_l3' => 1,
        'final09_d2_l4' => 1,
        'final09_d2_l5' => 1,
        // sunflower
        'final21_d2_l1' => 1,
        'final21_d2_l2' => 1,
        'final21_d2_l3' => 1,
        'final21_d2_l4' => 1,
        'final21_d2_l5' => 1,
        // grass and water
        'final06_d2_l1' => 1,
        'final06_d2_l2' => 1,
        'final06_d2_l3' => 1,
        'final06_d2_l4' => 1,
        'final06_d2_l5' => 1,
        // grass and water
        'final08_d2_l1' => 1,
        'final08_d2_l2' => 1,
        'final08_d2_l3' => 1,
        'final08_d2_l4' => 1,
        'final08_d2_l5' => 1,
        // grass and water
        'final18_d2_l1' => 1,
        'final18_d2_l2' => 1,
        'final18_d2_l3' => 1,
        'final18_d2_l4' => 1,
        'final18_d2_l5' => 1,
        // grass and water
        'final19_d2_l1' => 1,
        'final19_d2_l2' => 1,
        'final19_d2_l3' => 1,
        'final19_d2_l4' => 1,
        'final19_d2_l5' => 1
    ];


            foreach ($answers as $answer) {
                $path_parts = pathinfo($answer->image);

                foreach ($images as $image => $key) {
                    if ($image == $path_parts['filename']) {
                        // echo $path_parts['filename'] . " " . $key . "<br>";
                        $path_parts['filename'] = $key;
                    }
                }
                
                $ans = $categories[$answer->answer];

                echo "<div>"
                        . $answer->id . 
                    ' ' . $path_parts['filename'] . 
                    ' ' . $ans . 
                    ' ' . $answer->subject . 
                '</div>';
            }
        ?>
    </body>
</html>
