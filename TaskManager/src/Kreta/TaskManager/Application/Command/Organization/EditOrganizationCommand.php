<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kreta\TaskManager\Application\Command\Organization;

class EditOrganizationCommand
{
    private $id;
    private $name;
    private $editorId;
    private $slug;

    public function __construct(string $id, string $name, string $editorId, string $slug = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->editorId = $editorId;
        $this->slug = $slug;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function editorId() : string
    {
        return $this->editorId;
    }

    public function slug()
    {
        return $this->slug;
    }
}
