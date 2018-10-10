/*IMPORTAÇÃO WIDL.PROD08*/
INSERT INTO widl.PROD08
select convert(varchar,procod) as procod,'1' as seq,'0'as for1,'0' as for2,'0' as for3,
'S' as ativa,'N' atv2,'13/06/2016','ELOIR',
'Ø'+' '+convert(varchar,materialBrt)+' - '+convert(varchar,procodMat) as descricao,
'0' as for4,'' as for5, '1753-01-01 00:00:00.000' as for6,'0' as for7,'0' as for8,
null as for9,''as for10,'' as for11,'0' as for12,'0' as for13,
'' as for14,'' as for15,null as for9,null as for9,null as for9
from ESTRUTURAIMP$ where procod = '10110101'


   
insert into widl.PROD081
select convert(varchar,ESTRUTURAIMP$.procod) as procod,
1 as seq,'' as for1,procodMat,'0' as for1,(widl.prod01.propesprat +(widl.prod01.propesprat/100)*15) as consumo,
'0' as for1,'' as for2,'0' as for2,'0' as for3,'0' as for1,'S' as for4,'' as for2,'' as for2,'' as for3,
'PORCAS Á FRIU' as aplic,'0' as for1,'0' as for1,'0' as for1,'0' as for1,'0' as for1,'' as for1,
prodmat.prodes,'0' as for1,'0' as for1,'0' as for1,'0' as for1,'0' as for1,
'0' as for1,'0' as for1,'' as for3,'0' as for1,'0' as for1,'' as for3,
null as for9,null as for9,null as for9,null as for9,null as for9,null as for9,null as for9
from ESTRUTURAIMP$ left outer join widl.prod01 
on widl.prod01.procod = ESTRUTURAIMP$.procod left outer join widl.prod01 as prodmat
on prodmat.procod = ESTRUTURAIMP$.procodMat
where ESTRUTURAIMP$.procod = 10110101


select * from ESTRUTURAIMP$ left outer join widl.prod01 
on widl.prod01.procod = ESTRUTURAIMP$.procod 
where ESTRUTURAIMP$.procod = 10110101

