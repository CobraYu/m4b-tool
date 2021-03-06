<?php

namespace M4bTool\Audio\Tag;

use M4bTool\Audio\Tag;
use PHPUnit\Framework\TestCase;

class ContentMetadataJsonTest extends TestCase
{

    const FILE_CONTENT = <<<EOT
{
  "content_metadata": {
    "chapter_info": {
      "brandIntroDurationMs": 4010,
      "brandOutroDurationMs": 2383,
      "chapters": [
        {
          "length_ms": 1111,
          "title": "One"
        },
        {
          "length_ms": 2222,
          "title": "Two"
        },
        {
          "length_ms": 3333,
          "title": "Three"
        }
      ]
    },
    "content_reference": {
      "asin": "SAMPLEHASH"
    }
  }
  
}

EOT;


    public function testLoad()
    {
        $subject = new ContentMetadataJson(static::FILE_CONTENT);
        $tag = $subject->improve(new Tag());
        $this->assertEquals($tag->extraProperties["audible_id"], "SAMPLEHASH");
        $this->assertCount(5, $tag->chapters);
        $this->assertEquals("Intro", $tag->chapters[0]->getName());
        $this->assertEquals("One", $tag->chapters[1]->getName());
        $this->assertEquals("Two", $tag->chapters[2]->getName());
        $this->assertEquals("Three", $tag->chapters[3]->getName());
        $this->assertEquals("Outro", $tag->chapters[4]->getName());


    }
}
