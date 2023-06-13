<?php
class Thesaurus
{
    private $thesaurus;

    public function __construct($thesaurus)
    {
        $this->thesaurus = $thesaurus;
    }

    public function getSynonyms($word)
    {
        $synonyms = array_key_exists($word, $this->thesaurus) ? $this->thesaurus[$word] : [];

        return json_encode([
            "word" => $word,
            "synonyms" => $synonyms
        ]);
    }
}

$thesaurus = new Thesaurus([
    "market" => ["trade"],
    "small" => ["little", "compact"]
]);

echo $thesaurus->getSynonyms("small"); // outputs: {"word":"small","synonyms":["little", "compact"]}

echo $thesaurus->getSynonyms("asleast"); // outputs: {"word":"asleast","synonyms":[]}
?>
