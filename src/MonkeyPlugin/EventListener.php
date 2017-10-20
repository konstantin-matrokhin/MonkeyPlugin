<?php

namespace MonkeyPlugin;

use onebone\economyapi\EconomyAPI;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;

class EventListener implements Listener {

    public function __construct() {

    }

    public function onBlockBreak(BlockBreakEvent $event) {
        $p = $event->getPlayer();
        if ($event->isCancelled() ) return;
        if (!empty($event->getDrops())) {
            $rnd = rand(0, 3);
            if ($rnd < 1) return;
            EconomyAPI::getInstance()->addMoney($p->getName(), $rnd);
            $p->sendMessage("§aВы заработали §c$" . $rnd);
        }
    }

    /*public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $donate = file_get_contents("http://monkeycraft.ru/scripts/get_donate.php?player=" . $player->getName());
        if (!empty($donate)) {
            MonkeyPlugin::get()->getServer()->broadcastMessage(
                "§e" . $player->getName() . " §cкупил привилегию §e" . $donate
            );
            MonkeyPlugin::get()->getServer()->dispatchCommand(
                new ConsoleCommandSender(),
                "setgroup " . $player->getName() . " " .$donate
            );
        }
    }*/

}

?>