<?php

namespace MonkeyPlugin;

use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class MonkeyPlugin extends PluginBase {

    public $dropperBlocks;
    public $dropIds = array();
    public $toRun = true;
    public $eco;

    private static $plugin;

    function __construct() {
        self::$plugin = $this;
    }

    public function onEnable() {

        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->loadDroppers();
        $this->loadIds();

        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");

        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        $this->getServer()->getScheduler()->scheduleDelayedRepeatingTask(new DropperTask($this->dropperBlocks), 20 * 30, 20 * 60);
    }

    private function loadIds() {
        if (empty($this->getConfig()->get('id-list'))) {
            $this->getConfig()->set('id-list', [1, 2, 3, 4]);
            $this->saveConfig();
            $this->reloadConfig();
            $this->loadIds();
        } else {
            $this->dropIds = $this->getConfig()->get('id-list');
        }
    }

    private function loadDroppers() {
        if (empty($this->getConfig()->get('droppers'))) {
            $this->getConfig()->set('droppers', array());
            $this->saveConfig();
            $this->reloadConfig();
            $this->toRun = false;
        } else {
            foreach ($this->getConfig()->get('droppers') as $d) {
                $this->dropperBlocks[] = array($d[0], $d[1], $d[2]);
            }
        }
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        if ($sender instanceof Player) { $p = $sender; } else { return false; }

        if (strtolower($command->getName()) == 'setdropper' && $p->isOp()) {
            $block = $p->getTargetBlock(10);
            if ($block->getId() == 57) { // 57 - diamond block
                $blockInfo = [
                    $block->getX(),
                    $block->getY(),
                    $block->getZ()
                ];
                $allDroppers = $this->getConfig()->get('droppers');
                $allDroppers[$args[0]] = $blockInfo;
                $this->getConfig()->set('droppers', $allDroppers);
                $this->saveConfig();
                $this->reloadConfig();
                $p->sendMessage("§aДроппер установлен! Изменения вступят в силу после §c/reload");
            } else {
                $p->sendMessage("§cНужно смотреть на алмазный блок!");
            }
        }
        return false;
    }

    public static function get() {
        return self::$plugin;
    }

}

?>