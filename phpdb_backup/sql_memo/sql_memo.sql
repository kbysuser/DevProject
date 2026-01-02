CREATE TABLE `answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text,
  `questionId` text,
  `answer` text,
  `comment` text,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;

select questionId,answer,count(*) 
    from answers  
    group by questionId,answer     
    order by questionId,answer ;

-- 集計する
select questionId,avg(cast(answer as decimal)) as avg_answer
  from answers
  group by questionId;

