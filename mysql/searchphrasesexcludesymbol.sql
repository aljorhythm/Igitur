SELECT 
    *,
    SUM(IF(phs.LogicalConnectiveSymbol_idLogicalConnectiveSymbol = '4',
        1,
        0)) AS exclude
FROM
    Igitur.LogicalConnectivePhrase p
        left join
    Igitur.LogicalConnectivePhrase_has_LogicalConnectiveSymbol phs ON p.idLogicalConnectivePhrase = phs.LogicalConnectivePhrase_idLogicalConnectivePhrase
where p.logicalConnectivePhrase like ('%%')
group by p.idLogicalConnectivePhrase
having exclude = 0 order by p.LogicalConnectivePhrase; 
