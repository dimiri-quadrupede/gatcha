<?php
namespace GameBundle\Repository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Player;

use GameBundle\GameBundle;
/**
 * Description of BoxEquipeRepository
 *
 * @author lmq-dimitri
 */
class BoxEquipeRepository extends EntityRepository{
    //put your code here
    
    public function findBox(Player $player)
    {
        $dql = $this->createQueryBuilder("e") 
                ->leftJoin('e.affects', "a")
                ->leftJoin('a.playerBox', "pb")
                ->andWhere('pb.player = :playerId')
                ->setMaxResults( GameBundle::$max_team )
                ->orderBy("e.ranked","ASC");
                ;
 
        $dql->setParameter("playerId", $player->getId());
        
        $query = $dql->getQuery() ;      
        
        //print($query2->getSQL()."<br/>");
        
        //print(print_r($query2->getParameters(),1)."<br/>");
        
        $result = $query->getResult();
        
        return $result ;
    }
    
}
