<?php

namespace Sventendo\AdventOfCode2018\Day\Day8;

use Sventendo\AdventOfCode2018\Tests\TestCase;

class TreeTest extends TestCase
{
    /**
     * @var Tree
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->container->make(Tree::class);
    }

    public function testTraverse()
    {
        $input = '2 3 0 3 10 11 12 1 1 0 1 99 2 1 1 2';
        $data = explode(' ', trim($input));
        $this->subject->setData($data);
        $this->subject->traverse();
        $this->assertEquals(138, $this->subject->getSumOfMetaDataEntries());
    }
}
