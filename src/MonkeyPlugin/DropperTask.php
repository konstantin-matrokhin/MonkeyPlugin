<?php

namespace MonkeyPlugin;

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;

class DropperTask extends Task {

    public function onRun($tick) {
        if (!MonkeyPlugin::get()->toRun || count(MonkeyPlugin::get()->getServer()->getOnlinePlayers()) <= 1) return;
        //if (MonkeyPlugin::get()->getServer()->getDefaultLevel()->getTime() > 14000) return;
        foreach (MonkeyPlugin::get()->dropperBlocks as $blockPos) {
            for ($i = 0; $i < 3; $i++) {
                MonkeyPlugin::get()->getServer()->getDefaultLevel()->dropItem(
                    new Vector3($blockPos[0], $blockPos[1], $blockPos[2]),
                    new Item(MonkeyPlugin::get()->dropIds[array_rand(MonkeyPlugin::get()->dropIds)], 0)
                );
            }
        }
    }
}