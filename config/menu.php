<?php

$menu   = [
    [
        "title" => "Dashboard",
        "link"  => "index",
        "icon"  => "dashboard",
        "as"    => "dashboard.",
        "sub"   => [
        ]
    ],
    // [
    //     "title" => "Landing",
    //     "link"  => "#",
    //     "icon"  => "vcard-o",
    //     "as"    => "landing.",
    //     "sub"   => [
    //         [
    //             "title" => "List All",
    //             "link"  => "landing",
    //             "icon"  => "circle-o",
    //             "as"    => "",
    //         ]
    //     ]
    // ],[
    //     "title" => "Logistic",
    //     "link"  => "#",
    //     "icon"  => "vcard-o",
    //     "as"    => "logistic.",
    //     "sub"   => [
    //         [
    //             "title" => "List Batch",
    //             "link"  => "logistic",
    //             "icon"  => "circle-o",
    //             "as"    => "",
    //         ],
    //         [
    //             "title" => "List Orders",
    //             "link"  => "logistic/orders",
    //             "icon"  => "circle-o",
    //             "as"    => "",
    //         ],
    //         [
    //             "title" => "List Cs Logistic",
    //             "link"  => "logistic/cs",
    //             "icon"  => "circle-o",
    //             "as"    => "",
    //         ]
    //     ]
    // ],

    [
        "title" => "Product",
        "link"  => "#",
        "icon"  => "vcard-o",
        "as"    => "product.",
        "sub"   => [
            [
                "title" => "Product Data",
                "link"  => "product",
                "icon"  => "circle-o",
                "as"    => "",
            ],
            [
                "title" => "Product Category",
                "link"  => "category",
                "icon"  => "circle-o",
                "as"    => "",
            ],
            [
                "title" => "Product Tag",
                "link"  => "tag",
                "icon"  => "circle-o",
                "as"    => "",
            ]
        ]
    ],

    [
        "title" => "Order",
        "link"  => "#",
        "icon"  => "vcard-o",
        "sub"   => [
            [
                "title" => "Order list",
                "link"  => "order",
                "icon"  => "circle-o",
                "as"    => "order",
            ],
            [
                "title" => "Payment",
                "link"  => "payment",
                "icon"  => "circle-o",
                "as"    => "payment",
            ],
        ]
    ],
    // [
    //     "title" => "BCA",
    //     "link"  => "#",
    //     "icon"  => "vcard-o",
    //     "as"    => "bca.",
    //     "sub"   => [
    //         [
    //             "title" => "List All",
    //             "link"  => "bca",
    //             "icon"  => "circle-o",
    //             "as"    => "",
    //         ]
    //     ]
    // ],
    // [
    //     "title" => "Administrator",
    //     "link"  => "#",
    //     "icon"  => "vcard-o",
    //     "as"    => "administrator.",
    //     "sub"   => [
    //         [
    //             "title" => "List All",
    //             "link"  => "administrator",
    //             "icon"  => "circle-o",
    //             "as"    => "",
    //         ],
    //         [
    //             "title" => "Roles",
    //             "link"  => "administrator/role",
    //             "icon"  => "unlock",
    //             "as"    => "role.",
    //         ],
    //         [
    //             "title" => "Permission",
    //             "link"  => "administrator/permission",
    //             "icon"  => "key",
    //             "as"    => "permission.",
    //         ],
    //         [
    //             "title" => "Group",
    //             "link"  => "administrator/group",
    //             "icon"  => "users",
    //             "as"    => "group.",
    //         ]
    //     ]
    //         ],
];

return $menu;
