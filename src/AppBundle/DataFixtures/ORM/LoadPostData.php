<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $phpTag = new Tag('php');
        $jsTag = new Tag('js');
        $mysqlTag = new Tag('mysql');
        $symfonyTag = new Tag('symfony');

        $manager->persist($phpTag);
        $manager->persist($jsTag);
        $manager->persist($mysqlTag);
        $manager->persist($symfonyTag);
        $tags = [
            $phpTag,
            $jsTag,
            $mysqlTag,
            $symfonyTag,
        ];

        for ($i=0; $i<10; $i++) {
            $post = new Post();
//            $post->setSlug(sprintf('post_%d',$i));
            $post->setHeading(sprintf('Post_%d',$i));
            $post->setContent(<<<HEREDOC
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam neque, pulvinar eget enim viverra, tempor blandit leo. 
Aenean fringilla libero sit amet leo facilisis, at venenatis dolor cursus. Quisque maximus erat eu arcu pellentesque dignissim. Vestibulum ac egestas sapien. 
Sed id imperdiet ex. Donec id mi enim. Quisque ullamcorper mi sit amet augue tempor pretium. 
Phasellus auctor augue a erat aliquam ultricies a sed lectus. Sed vitae sem vitae velit hendrerit imperdiet.
HEREDOC
            );
            /** @var int[] $randomTagsIndexes */
            $randomTagsIndexes =  array_rand($tags, rand(2, count($tags)));
            foreach ($randomTagsIndexes as $index) {
                $post->getTags()->add($tags[$index]);
            }
            $manager->persist($post);
        }
        $manager->flush();
    }
}