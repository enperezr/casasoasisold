<?php

return [

    'feeds' => [
        [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * '\App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['\App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\Http\Controllers\PropertyController@getAllFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            'title' => 'Feeds Habana Oasis',
        ],
        [
            'items' => 'App\Http\Controllers\PropertyController@getAllFeedItemsForFb',
            'url'=> '/feed-fb',
            'title' => 'Feeds Habana Oasis Para Facebook'
        ]
    ]
];
