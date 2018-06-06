<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Animal;
use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\Day;
use AppBundle\Entity\HotSpot;
use AppBundle\Entity\HotSpotInfo;
use AppBundle\Entity\Medication;
use AppBundle\Entity\MedicationResults;
use AppBundle\Entity\Results;
use AppBundle\Entity\Test;
use AppBundle\Entity\TestResults;
use AppBundle\Entity\User;
use AppBundle\Entity\UserDay;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures implements FixtureInterface
{
  public function load(ObjectManager $manager) {
    $animal = new Animal();
    $caseStudy = new CaseStudy();
    $day = new Day();
    $hotspot = new HotSpot();
    $hotspotInfo = new HotSpotInfo();
    $medication = new Medication();
    $medicationResults = new MedicationResults();
    $test = new Test();
    $testResults = new TestResults();
    $user = new User();

    copy("web/images/StandardbredGelding.jpeg", "web/images/fixtureImage.jpeg");

    $animal->setName("Standardbred gelding")
      ->setWeight(485.5)
      ->setImage(new UploadedFile("web/images/fixtureImage.jpeg", "image", null, null, null, true));

    $caseStudy->setTitle("Fixture Case")
      ->setDescription("This is a barebones example case used for testing purposes")
      ->setEmail("email@example.org");

    $day->setDescription("Day 1");

    $hotspot->setName("Nostrils")
      ->setCoords(array("0.214444","0.311666","0.211111","0.353333","0.234444","0.36","0.241111","0.316666"));

    $hotspotInfo->setInfo("No abnormalities")
      ->setHotspot($hotspot);

    $medication->setName("Na penicillin G IV")
      ->setTGroup("Group 1")
      ->setCostPerUnit(4.65)
      ->setWaitTime(0)
      ->setDefaultResult("Default result");

    $medicationResults->setResults("Results for penicillin iv")
      ->setMedication($medication);

    $test->setName("Skin biopsy C/S")
      ->setDGroup("Microbiology")
      ->setCostPerUnit(2.85)
      ->setWaitTime(2)
      ->setDefaultResult("No growth after 48 hours");

    $testResults->setResults("Results for skin biopsy")
      ->setTest($test);

    $user->setUsername("netid");

    $day->addTest($testResults)
      ->addMedication($medicationResults)
      ->addHotspotsInfo($hotspotInfo);

    $caseStudy->addDay($day);

    $animal->addCase($caseStudy)
      ->addHotspot($hotspot);

    $manager->persist($animal);
    $manager->persist($caseStudy);
    $manager->persist($day);
    $manager->persist($hotspot);
    $manager->persist($medication);
    $manager->persist($test);
    $manager->persist($user);

    $manager->flush();
  }
}
