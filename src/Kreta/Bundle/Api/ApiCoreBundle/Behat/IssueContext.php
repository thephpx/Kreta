<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class IssueContext.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Behat
 */
class IssueContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following issues exist:$/
     */
    public function theFollowingIssuesExist(TableNode $issues)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach ($issues as $issueData) {
            $project = $this->getKernel()->getContainer()->get('kreta_core.repository.project')
                ->findOneBy(['name' => $issueData['project']]);
            $reporter = $this->getKernel()->getContainer()->get('kreta_core.repository.user')
                ->findOneBy(['email' => $issueData['reporter']]);
            $assignee = $this->getKernel()->getContainer()->get('kreta_core.repository.user')
                ->findOneBy(['email' => $issueData['assignee']]);
            $status = $this->getKernel()->getContainer()->get('kreta_core.repository.status')
                ->findOneBy(['name' => $issueData['status']]);

            $issue = $this->kernel->getContainer()->get('kreta_core.factory.issue')->create($project, $reporter);
            $issue->setId($issueData['id']);
            $issue->setNumericId($issueData['numericId']);
            $issue->setCreatedAt(new \DateTime($issueData['createdAt']));
            $issue->setPriority($issueData['priority']);
            $issue->setProject($project);
            $issue->setAssignee($assignee);
            $issue->setReporter($reporter);
            $issue->setStatus($status);
            $issue->setType($issueData['type']);
            $issue->setTitle($issueData['title']);
            $issue->setDescription($issueData['description']);

            $metadata = $manager->getClassMetaData(get_class($issue));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

            $manager->persist($issue);
        }

        $manager->flush();
    }
}