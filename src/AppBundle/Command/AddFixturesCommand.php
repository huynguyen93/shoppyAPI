<?php

namespace AppBundle\Command;

use AppBundle\Entity\Shoe;
use AppBundle\Entity\ShoeColorImage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddFixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:update-images');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $shoeManager = $this->getContainer()->get('app.manager.shoe');

        /** @var Shoe[] $shoes */
        $shoes = $shoeManager->findAll();
        $productType = 1;

        foreach ($shoes as $shoe) {
            $color = 1;
            $shoeColors  = $shoe->getColors();

            foreach ($shoeColors as $shoeColor) {
                for ($i = 1; $i <=5; $i++) {
                    $shoeColorImage = new ShoeColorImage();
                    $shoeColorImage->setShoeColor($shoeColor);
                    $shoeColorImage->setPosition(rand(1,10));
                    $shoeColorImage->setXl('/assets/img/prod'.$productType.'/color'.$color.'/style'.$i.'/extra-large.jpg');
                    $shoeColorImage->setLg('/assets/img/prod'.$productType.'/color'.$color.'/style'.$i.'/large.jpg');
                    $shoeColorImage->setMd('/assets/img/prod'.$productType.'/color'.$color.'/style'.$i.'/medium.jpg');
                    $shoeColorImage->setSm('/assets/img/prod'.$productType.'/color'.$color.'/style'.$i.'/small.jpg');

                    $em->persist($shoeColorImage);
                }

                $color = $color === 1 ? 2 : 1;
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
}
