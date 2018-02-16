<?php
namespace GameBundle\Repository ;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\ORM\EntityRepository;

/**
 * Description of PortailRepository
 *
 * @author lmq-dimitri
 */
class PortailRepository extends EntityRepository {
    //put your code here
    
    public function findOpened()
    {
        $date = new \DateTime();
        
        $dql = $this->createQueryBuilder("p") 
                ->andWhere(" p.startedAt <= :date ")
                ->andWhere(" p.endedAt > :date ")
                ;
        
        $dql->setParameter("date", $date);
        
        $query = $dql->getQuery() ;
        
        //print($query->getSQL()."<br/>");
        
        //print(print_r($query->getParameters(),1)."<br/>");
        
        $result = $query->getResult();
        
        //die(print_r($result,1)."<br/>");
        
        return $result ;
    }
}
