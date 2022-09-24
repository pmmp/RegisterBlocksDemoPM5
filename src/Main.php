<?php

declare(strict_types=1);

namespace dktapps\RegisterBlockDemoPM5;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\item\StringToItemParser;
use pocketmine\plugin\PluginBase;
use pocketmine\world\format\io\GlobalBlockStateHandlers;

class Main extends PluginBase{

	public function onEnable() : void{
		$block = CustomBlocks::TARGET();
		$this->registerSimpleBlock(BlockTypeNames::TARGET, $block, ["target"]);
	}

	/**
	 * @param string[] $stringToItemParserNames
	 */
	private function registerSimpleBlock(string $id, Block $block, array $stringToItemParserNames) : void{
		BlockFactory::getInstance()->register($block);

		GlobalBlockStateHandlers::getDeserializer()->mapSimple($id, fn() => clone $block);
		GlobalBlockStateHandlers::getSerializer()->mapSimple($block, $id);

		foreach($stringToItemParserNames as $name){
			StringToItemParser::getInstance()->registerBlock($name, fn() => clone $block);
		}
	}
}
