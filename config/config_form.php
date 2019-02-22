<?php

$formFields[0]['form'] = [
    'legend' => [
        'title' => $this->l('Settings'),
    ],
    'input' => [
        [
            'type' => 'switch',
            'label' => $this->l('Show on cart page'),
            'name' => 'show_on_cart_page',
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Enabled')
                ],
                [
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('Disabled')
                ]
            ],

        ],

        [
            'type' => 'switch',
            'label' => $this->l('Show on product page'),
            'name' => 'show_on_product_page',
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Enabled')
                ],
                [
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('Disabled')
                ]
            ],

        ],

        [
            'type' => 'switch',
            'label' => $this->l('Show on category page'),
            'name' => 'show_on_category_page',
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Enabled')
                ],
                [
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('Disabled')
                ]
            ],

        ],

        [
            'type' => 'text',
            'label' => $this->l('Notification text'),
            'desc' => $this->l(
                'Allowed combinations {leftToAmount: amount}, {leftToDate: date};' .
                'You can set notification text as "Add ${leftTo: 250} to your cart in order to receive free shipping;' .
                '"If you want to have promotion to t-shirts you have to place order in {leftToDate: 2019-01-06 23:59:59}";' .
                '"You order is only ${leftToAmount: amount} to get free shipping. Promotion expire in {leftToDate: 2019-01-06 23:59:59}";' .
                "Don't forget to setup the minutes and the hours word in your language."


            ),
            'name' => 'text',
            'size' => 30,
            'required' => true
        ],

        [
            'type' => 'switch',
            'label' => $this->l('Show a button on the notification'),
            'name' => 'enable_button',
            'values' => [
                [
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Enabled')
                ],
                [
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('Disabled')
                ]
            ],

        ],

        [
            'type' => 'text',
            'label' => $this->l('Button link url'),
            'name' => 'button_link_url',
            'size' => 30,
            'required' => false
        ],

        [
            'type' => 'text',
            'label' => $this->l('Minutes word'),
            'name' => 'minutes_word',
            'size' => 30,
            'required' => true
        ],

        [
            'type' => 'text',
            'label' => $this->l('Hours word'),
            'name' => 'hours_word',
            'size' => 30,
            'required' => true
        ],

        [
            'type' => 'select',
            'lang' => true,
            'label' => $this->l('Animation for the text'),
            'name' => 'animation',
            'options' => [
                'query' => [
                    ['id' => 'none', 'name' => 'none'],
                    ['id' => 'bounce', 'name' => 'bounce'],
                    ['id' => 'flash', 'name' => 'flash'],
                    ['id' => 'pulse', 'name' => 'pulse'],
                    ['id' => 'rubberBand', 'name' => 'rubberBand'],
                    ['id' => 'shake', 'name' => 'shake'],
                    ['id' => 'swing', 'name' => 'swing'],
                    ['id' => 'tada', 'name' => 'tada'],
                    ['id' => 'wobble', 'name' => 'wobble'],
                    ['id' => 'jello', 'name' => 'jello'],
                    ['id' => 'heartBeat', 'name' => 'heartBeat'],
                    ['id' => 'bounce', 'name' => 'bounce'],
                ],
                'id' => 'id',
                'name' => 'name'
            ]

        ],

        [
            'type' => 'select',
            'lang' => true,
            'label' => $this->l('Animation delay in seconds'),
            'name' => 'animation_delay',
            'options' => [
                'query' => [
                    ['id' => '0', 'name' => '0'],
                    ['id' => '1', 'name' => '1'],
                    ['id' => '2', 'name' => '2'],
                    ['id' => '3', 'name' => '3'],
                    ['id' => '4', 'name' => '4'],
                    ['id' => '5', 'name' => '5'],
                ],
                'id' => 'id',
                'name' => 'name'
            ]

        ],


    ],


    'submit' => [
        'title' => $this->l('Save'),
        'class' => 'btn btn-default pull-right'
    ]
];


