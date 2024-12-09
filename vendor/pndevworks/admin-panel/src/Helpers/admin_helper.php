<?php

if (!function_exists('admin_build_navbar')) {
    /**
     * This will handle the navbar grouping to reduce the dense problem
     * and improve the readibility.
     *
     * @see https://gitlab.com/PNDevworks/NewVespa/issues/7
     * @param String $active_table selected/active table name
     * @return Array array of objects
     */
    function admin_build_navbar($active_table)
    {
        $config = config('AdminPanel');
        $final_menu = [];

        $tables = $config->admin_tables;
        $groups = $config->admin_groups;
        foreach ($tables as $name => $items) {
            if (array_key_exists("-nav-group", $items)) {
                if (!array_key_exists($items["-nav-group"], $final_menu)) {
                    $final_menu[$items["-nav-group"]] = [
                        "label" => (array_key_exists($items["-nav-group"], $groups) ?
                            $groups[$items["-nav-group"]]['label'] :
                            $items["-nav-group"]),
                        "link" => "#",
                        "active" => false,
                        "child" => [],
                    ];
                }
                $final_menu[$items["-nav-group"]]['child'][] = [
                    "label" => $items['label'],
                    "link" => route_to('pnd_admin_index', $name, 1),
                    "active" => ($name == $active_table),
                ];
                $final_menu[$items["-nav-group"]]['active'] |= $name == $active_table;
            } else {
                $final_menu[$name] = [
                    "label" => $items["label"],
                    "link" => route_to('pnd_admin_index', $name, 1),
                    "active" => ($name == $active_table),
                    "child" => [],
                ];
            }
        }
        return $final_menu;
    }
}
