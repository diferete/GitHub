INSERT INTO widl.PROD08
select convert(varchar,procod) as procod,'1' as seq,'0'as for1,'0' as for2,'0' as for3,
'S' as ativa,'N' atv2,'30/01/2017','ELOIR',
convert(varchar,'Baixa')+' - '+convert(varchar,'porcas') as descricao,
'0' as for4,'' as for5, '1753-01-01 00:00:00.000' as for6,'0' as for7,'0' as for8,
null as for9,''as for10,'' as for11,'0' as for12,'0' as for13,
'' as for14,'' as for15,null as for9,null as for9,null as for9
from planilha1$ where procod = 50010305


insert into widl.PROD081
select convert(varchar,planilha1$.procod) as procod,
1 as seq,'' as for1,convert(varchar,porca),'0' as for1,'1' as consumo,
'0' as for1,'' as for2,'0' as for2,'0' as for3,'0' as for1,'S' as for4,'' as for2,'' as for2,'' as for3,
'PORCAS EMBALAGEM' as aplic,'0' as for1,'0' as for1,'0' as for1,'0' as for1,'0' as for1,'' as for1,
prodmat.prodes,'0' as for1,'0' as for1,'0' as for1,'0' as for1,'0' as for1,
'0' as for1,'0' as for1,'' as for3,'0' as for1,'0' as for1,'' as for3,
null as for9,null as for9,null as for9,null as for9,null as for9,null as for9,null as for9
from planilha1$ left outer join widl.prod01 
on widl.prod01.procod = planilha1$.procod left outer join widl.prod01 as prodmat
on prodmat.procod = planilha1$.porca
where planilha1$.procod = 50010305


select * from drop table planilha1$


SELECT * FROM widl.PROD081 order by procod desc


select * from widl.PROD08 where procod = 50010305

select * from widl.PROD081 where procod = 50010305

