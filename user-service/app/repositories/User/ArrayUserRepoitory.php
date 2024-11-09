<?php

namespace App\Repositories\User;

use App\Entities\User;
use Slim\Exception\HttpNotFoundException;
class ArrayUserRepoitory implements UserRepositoryInterface
{


    private array $users = [
        
    ];
    public function __construct()
    {
        $this->users = [
            new User(1, "Beverly Miller", "vanessa16@yahoo.com"),
            new User(2, "Diane Branch", "crawfordlaurie@ward.com"),
            new User(3, "Karina Cruz", "crystalhendricks@bowen.com"),
            new User(4, "Lisa Baker", "dianedavis@yahoo.com"),
            new User(5, "Marissa Bass", "edward69@white.com"),
            new User(6, "Mr. James Morales", "matthew58@flynn.info"),
            new User(7, "Jane Cantu", "thill@english-wilson.info"),
            new User(8, "Dylan Patel", "vwilliams@franco.com"),
            new User(9, "Jessica Watson", "thomastamara@yahoo.com"),
            new User(10, "Jeffrey Ferguson", "acox@hotmail.com"),
            new User(11, "Alyssa Salazar", "luis76@yahoo.com"),
            new User(12, "Nancy Vazquez", "qwalters@hotmail.com"),
            new User(13, "William Gonzalez", "sbrown@thomas.com"),
            new User(14, "Kimberly Hurley", "sarah43@yahoo.com"),
            new User(15, "Timothy Smith", "scottbutler@butler.com"),
            new User(16, "Angela Anderson", "morrisonjoyce@grimes-middleton.net"),
            new User(17, "Brian Green", "menglish@small.net"),
            new User(18, "Brittney Hamilton", "christopherroberts@phillips.org"),
            new User(19, "Tony Glenn", "ian31@yahoo.com"),
            new User(20, "Stephanie Watson", "eric95@rojas.com"),
        ];
    }

    public function findById(int $id): ?User
    {
        foreach ($this->users as $user) {
            if ($user->userId == $id) {
                return $user;
            }
        }

        return null;

    }

    public function getAllUsers(): array
    {
        return $this->users;
    }

}

