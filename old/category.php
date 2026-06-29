
<?php
class CategoryCheck {

    public function categorycheck($name, $category)
    {
        // combine inputs
        $text = strtolower($name . ' ' . $category);

        // keywords related to travel & hospitality
        $keywords = [
            'travel',
            'tour',
            'tourism',
            'agency',
            'agent',
            'hotel',
            'hospitality',
            'resort',
            'lodging',
            'booking',
            'flight',
            'airline',
            'vacation',
            'holiday'
        ];

        // check if any keyword exists in text
        foreach ($keywords as $word) {
            if (strpos($text, $word) !== false) {
                return true;
            }
        }

        return false;
    }
}
?>