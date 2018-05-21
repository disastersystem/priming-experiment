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
        <?php
            $images = [
                'final01_d2_l1' => 1,
                'final01_d2_l2' => 2,
                'final01_d2_l3' => 3,
                'final01_d2_l4' => 4,
                'final01_d2_l5' => 5,
                // 
                'final02_d2_l1' => 6,
                'final02_d2_l2' => 7,
                'final02_d2_l3' => 8,
                'final02_d2_l4' => 9,
                'final02_d2_l5' => 10,
                // 
                'final07_d2_l1' => 11,
                'final07_d2_l2' => 12,
                'final07_d2_l3' => 13,
                'final07_d2_l4' => 14,
                'final07_d2_l5' => 15,
                //
                'final20_d2_l1' => 16,
                'final20_d2_l2' => 17,
                'final20_d2_l3' => 18,
                'final20_d2_l4' => 19,
                'final20_d2_l5' => 20,
                // 
                'final16_d2_l1' => 21,
                'final16_d2_l2' => 22,
                'final16_d2_l3' => 23,
                'final16_d2_l4' => 24,
                'final16_d2_l5' => 25,
                // 
                'final09_d2_l1' => 26,
                'final09_d2_l2' => 27,
                'final09_d2_l3' => 28,
                'final09_d2_l4' => 29,
                'final09_d2_l5' => 30,
                // 
                'final21_d2_l1' => 31,
                'final21_d2_l2' => 32,
                'final21_d2_l3' => 33,
                'final21_d2_l4' => 34,
                'final21_d2_l5' => 35,
                // 
                'final06_d2_l1' => 36,
                'final06_d2_l2' => 37,
                'final06_d2_l3' => 38,
                'final06_d2_l4' => 39,
                'final06_d2_l5' => 40,
                // 
                'final08_d2_l1' => 41,
                'final08_d2_l2' => 42,
                'final08_d2_l3' => 43,
                'final08_d2_l4' => 44,
                'final08_d2_l5' => 45,
                // 
                'final18_d2_l1' => 46,
                'final18_d2_l2' => 47,
                'final18_d2_l3' => 48,
                'final18_d2_l4' => 49,
                'final18_d2_l5' => 50,
                // 
                'final19_d2_l1' => 51,
                'final19_d2_l2' => 52,
                'final19_d2_l3' => 53,
                'final19_d2_l4' => 54,
                'final19_d2_l5' => 55
            ];

            $categories = ['bad' => 1, 'poor' => 2, 'fair' => 3, 'good' => 4, 'excellent' => 5];

            foreach ($answers as $answer) {
                $path_parts = pathinfo($answer->image);

                foreach ($images as $image => $key) {
                    if ($image == $path_parts['filename']) {
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
