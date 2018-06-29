<?php

namespace AppBundle\Command;

use AppBundle\Entity\Color;
use AppBundle\Entity\Shoe;
use AppBundle\Entity\ShoeColorImage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddFixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:update-fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();

        $shoeManager = $container->get('app.manager.shoe');
        $colorManager = $container->get('app.manager.color');

        /** @var Color[] $colors */
        $colors = $colorManager->findAll();

        /** @var Shoe[] $shoes */
        $shoes = $shoeManager->findAll();
        $productType = 1;

        foreach ($shoes as $shoe) {
            /** @var Color $color */
            $colorFolder = 1;
            $shoeColors  = $shoe->getShoeColors();
            $lastColor = [];

            foreach ($shoeColors as $shoeColor) {
                $color = $this->getUniqueColor($colors, $lastColor);
                $lastColor[] = $color;
                $shoeColor->setColor($color);
                $shoeColor->setSlug(null);
                $shoeColor->setName($shoe->getName() . ' ' . $color->getName());

                for ($i = 1; $i <=5; $i++) {
                    $shoeColorImage = new ShoeColorImage();
                    $shoeColorImage->setShoeColor($shoeColor);
                    $shoeColorImage->setPosition(rand(1,10));
                    $shoeColorImage->setXl('/assets/img/prod'.$productType.'/color'.$colorFolder.'/style'.$i.'/extra-large.jpg');
                    $shoeColorImage->setLg('/assets/img/prod'.$productType.'/color'.$colorFolder.'/style'.$i.'/large.jpg');
                    $shoeColorImage->setMd('/assets/img/prod'.$productType.'/color'.$colorFolder.'/style'.$i.'/medium.jpg');
                    $shoeColorImage->setSm('/assets/img/prod'.$productType.'/color'.$colorFolder.'/style'.$i.'/small.jpg');

                    $em->persist($shoeColor);
                    $em->persist($shoeColorImage);
                }

                $colorFolder = $colorFolder === 1 ? 2 : 1;
            }

            if ($productType === 4) {
                $productType = 1;
            } else {
                $productType++;
            };
        }

        $em->flush();
        echo "OK";
    }

    /**
     * @param Color[] $colors
     * @param Color[] $insertedColors
     * @return Color
     */
    private function getUniqueColor(array $colors, array $insertedColors)
    {
        while (true) {
            $color = $colors[array_rand($colors)];

            if (!in_array($color, $insertedColors)) {
                return $color;
            }
        }

        return null;
    }
}
