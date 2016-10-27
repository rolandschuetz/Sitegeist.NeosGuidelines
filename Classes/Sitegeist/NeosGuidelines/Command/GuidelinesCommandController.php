<?php
namespace Sitegeist\NeosGuidelines\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Sitegeist.NeosGuidelines".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Cli\CommandController;

/**
 * @Flow\Scope("singleton")
 */
class GuidelinesCommandController extends CommandController
{

    /**
     * @Flow\Inject
     * @var \Sitegeist\NeosGuidelines\Utility\FileUtilities
     */
    protected $fileUtilities;

    /**
     * Validate the current project against the Sitegeist Neos Guidelines
     *
     * @return void
     */
    public function validateCommand() 
    {

        if (!$this->fileUtilities->fileExists('.editorconfig')) {
            throw new \Exception('No Editorconfig found in the root directory of the project.');
        }

        if (!$this->fileUtilities->fileIsInVCS('composer.lock')) {
            throw new \Exception('No composer.lock found in your git repository.');
        }

        if (!$this->fileUtilities->fileExists('README.md')) {
            throw new \Exception('No README.md found in the root directory of the project.');
        }

        $readme = file('README.md');
        if (!in_array("# Installation\n", $readme)) {
            throw new \Exception('No Installation section found in your README.md.');
        } else if (!in_array("# Versionskontrolle\n", $readme)) {
            throw new \Exception('No Versionskontrolle section found in your README.md.');
        } else if (!in_array("# Deployment\n", $readme)) {
            throw new \Exception('No Deployment section found in your README.md.');
        }

    }
    
    

}
