<?php
namespace GameBundle\Repository ;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\ORM\EntityRepository;

use GameBundle\Entity\Portail;
use AppBundle\Entity\Player;
/**
 * Description of PersonnageRepository
 *
 * @author lmq-dimitri
 */
class PersonnageRepository extends EntityRepository {
    //put your code here
    
    public function findBox(Player $player)
    {
        $dql = $this->createQueryBuilder("p") 
                ->leftJoin('p.playerBoxes', "pb")
                ->andWhere('pb.player = :playerId');
 
        $dql->setParameter("playerId", $player->getId());
        
        $query = $dql->getQuery() ;      
        
        //print($query2->getSQL()."<br/>");
        
        //print(print_r($query2->getParameters(),1)."<br/>");
        
        $result = $query->getResult();
        
        return $result ;
    }
    
    public function findRandom(Portail $portail)
    {
        $dql = $this->createQueryBuilder("p") 
                ->leftJoin('p.portailBoxes', "pb")
                ->andWhere('pb.portail = :portailId');
 
        $dql->setParameter("portailId", $portail->getId());
        
        $query = $dql->getQuery() ;      
        
        //print($query2->getSQL()."<br/>");
        
        //print(print_r($query2->getParameters(),1)."<br/>");
        
        $result = $query->getResult();
                
        $key = array_rand($result , 1 ) ;
        
        return $result[$key];
    }    
    
    public function off_findRandom(Portail $portail)
    {
        $dql = $this->createQueryBuilder("count(p)") 
                ->leftJoin('p.portailBox', "pb")
                ->andWhere('pb.portail = :portailId');
 
        $dql2->setParameter("portailId", $portail->getId());
        
        $query = $dql->getQuery() ;
                
        $result = $query->getScalarResult();

        $dql2 = $this->createQueryBuilder("p") 
                ->leftJoin('p.portailBox', "pb")
                ->andWhere('pb.portail = :portailId')
                ->limit(1)
                ->offset(rand(0, intval($result - 1) ))
                ;
        
        $dql2->setParameter("portailId", $portail->getId());
        
        $query2 = $dql2->getQuery() ;
        
        //print($query2->getSQL()."<br/>");
        
        //print(print_r($query2->getParameters(),1)."<br/>");
        
        $result2 = $query2->getResult();
                
        //return $result ;
    }
}
