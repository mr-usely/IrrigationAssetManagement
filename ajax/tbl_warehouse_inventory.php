<?php 
require_once("../../../Initialization/initialize.php");

$FarmNumber = $_GET['farm_number'];

$sql = "
Select * From
(
	Select 1 Sort, 'PHASE 1' Phase, '' Assembly, '' ItemNames, '' Unit, '' Classification, '' TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '%' Returns
	Union
	Select 1 Sort, Phase, Assembly, ItemNames, Unit, 'CAPEX' Classification,
		   ISNULL(TotalIssuance,0) TotalIssuance,
		   ISNULL(Used, 0) Used,
		   ISNULL(ForRepair, 0) ForRepair,
		   ISNULL(DamagedScrap, 0) DamagedScrap,
		   ISNULL(TotalIssuance - TotalReturns, 0) Total,
		   ISNULL(TotalReturns,0) TotalReturns,
		   CONVERT(varchar,ROUND(ISNULL(Case When TotalReturns <= 0 Then 0 Else TotalIssuance/TotalReturns End, 0), 2))+'%' Returns
	From consIrrigItems Items
	Left Join (
		Select ItemName, TotalIssuance, Used, ForRepair, DamagedScrap, (Used + ForRepair + DamagedScrap) TotalReturns
		From (
			Select ItemName,
				SUM(Case When Category = 'Issuance' Then Quantity Else 0 End) TotalIssuance,
				SUM(Case When ItemStatus = 'Used' AND Category = 'Returns' Then Quantity Else 0 End) Used,
				SUM(Case When ItemStatus = 'For Repair' AND Category = 'Returns' Then Quantity Else 0 End) ForRepair,
				SUM(Case When ItemStatus = 'Damaged/Scrap' AND Category = 'Returns' Then Quantity Else 0 End) DamagedScrap
			From IrrigItemNames Where ID IN (
				Select PK From IrrigDocument Where Assignee IN (
					Select Name From tblULFS Where FarmerNo IN (
						Select FarmerNo From consIrrigAuthorizedRep Where FarmerNo = '%{$FarmNumber}%'
						Group By FarmerNo
					)
				)
			)
			Group By ItemName
		) A
	) total ON items.ItemNames = total.ItemName
	Where Phase !='' AND Phase = 'PHASE 1'
	Union
	Select 2 Sort, 'PHASE 2' Phase, '' Assembly, '' ItemNames, '' Unit, '' Classification, '' TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '%' Returns
	Union
	Select 2 Sort, Phase, Assembly, ItemNames, Unit, Classification, TotalIssuance, Used, ForRepair, DamagedScrap, Total, TotalReturns, Returns From (
		Select 1 sort, '' Phase, 'MAINLINE NETWORK' Assembly, '' ItemNames, '' Unit, '' Classification, 0 TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '0%' Returns
		Union
		Select 1 sort, Phase, Assembly, ItemNames, Unit, 'CAPEX' Classification,
			   ISNULL(TotalIssuance,0) TotalIssuance,
			   ISNULL(Used, 0) Used,
			   ISNULL(ForRepair, 0) ForRepair,
			   ISNULL(DamagedScrap, 0) DamagedScrap,
			   ISNULL(TotalIssuance - TotalReturns, 0) Total,
			   ISNULL(TotalReturns,0) TotalReturns,
			   CONVERT(varchar,ROUND(ISNULL(Case When TotalReturns <= 0 Then 0 Else TotalIssuance/TotalReturns End, 0), 2))+'%' Returns
		From consIrrigItems Items
		Left Join (
			Select ItemName, TotalIssuance, Used, ForRepair, DamagedScrap, (Used + ForRepair + DamagedScrap) TotalReturns
			From (
				Select ItemName,
					SUM(Case When Category = 'Issuance' Then Quantity Else 0 End) TotalIssuance,
					SUM(Case When ItemStatus = 'Used' AND Category = 'Returns' Then Quantity Else 0 End) Used,
					SUM(Case When ItemStatus = 'For Repair' AND Category = 'Returns' Then Quantity Else 0 End) ForRepair,
					SUM(Case When ItemStatus = 'Damaged/Scrap' AND Category = 'Returns' Then Quantity Else 0 End) DamagedScrap
				From IrrigItemNames Where ID IN (
					Select PK From IrrigDocument Where Assignee IN (
						Select Name From tblULFS Where FarmerNo IN (
							Select FarmerNo From consIrrigAuthorizedRep Where FarmerNo = '%{$FarmNumber}%'
							Group By FarmerNo
						)
					)
				)
				Group By ItemName
			) A
		) total ON items.ItemNames = total.ItemName
		Where Phase !='' AND Phase = 'PHASE 2' AND Assembly = 'MAINLINE NETWORK'
		Union
		Select 2 sort, '' Phase, 'SECONDARY FILTER' Assembly, '' ItemNames, '' Unit, '' Classification, 0 TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '0%' Returns
		Union
		Select 2 sort, Phase, Assembly, ItemNames, Unit, 'CAPEX' Classification,
			   ISNULL(TotalIssuance,0) TotalIssuance,
			   ISNULL(Used, 0) Used,
			   ISNULL(ForRepair, 0) ForRepair,
			   ISNULL(DamagedScrap, 0) DamagedScrap,
			   ISNULL(TotalIssuance - TotalReturns, 0) Total,
			   ISNULL(TotalReturns,0) TotalReturns,
			   CONVERT(varchar,ROUND(ISNULL(Case When TotalReturns <= 0 Then 0 Else TotalIssuance/TotalReturns End, 0), 2))+'%' Returns
		From consIrrigItems Items
		Left Join (
			Select ItemName, TotalIssuance, Used, ForRepair, DamagedScrap, (Used + ForRepair + DamagedScrap) TotalReturns
			From (
				Select ItemName,
					SUM(Case When Category = 'Issuance' Then Quantity Else 0 End) TotalIssuance,
					SUM(Case When ItemStatus = 'Used' AND Category = 'Returns' Then Quantity Else 0 End) Used,
					SUM(Case When ItemStatus = 'For Repair' AND Category = 'Returns' Then Quantity Else 0 End) ForRepair,
					SUM(Case When ItemStatus = 'Damaged/Scrap' AND Category = 'Returns' Then Quantity Else 0 End) DamagedScrap
				From IrrigItemNames Where ID IN (
					Select PK From IrrigDocument Where Assignee IN (
						Select Name From tblULFS Where FarmerNo IN (
							Select FarmerNo From consIrrigAuthorizedRep Where FarmerNo = '%{$FarmNumber}%'
							Group By FarmerNo
						)
					)
				)
				Group By ItemName
			) A
		) total ON items.ItemNames = total.ItemName
		Where Phase !='' AND Phase = 'PHASE 2' AND Assembly = 'SECONDARY FILTER'
		Union
		Select 3 sort, '' Phase, 'DISTRIBUTION NETWORK' Assembly, '' ItemNames, '' Unit, '' Classification, 0 TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '0%' Returns
		Union
		Select 3 sort, Phase, Assembly, ItemNames, Unit, 'CAPEX' Classification,
			   ISNULL(TotalIssuance,0) TotalIssuance,
			   ISNULL(Used, 0) Used,
			   ISNULL(ForRepair, 0) ForRepair,
			   ISNULL(DamagedScrap, 0) DamagedScrap,
			   ISNULL(TotalIssuance - TotalReturns, 0) Total,
			   ISNULL(TotalReturns,0) TotalReturns,
			   CONVERT(varchar,ROUND(ISNULL(Case When TotalReturns <= 0 Then 0 Else TotalIssuance/TotalReturns End, 0), 2))+'%' Returns
		From consIrrigItems Items
		Left Join (
			Select ItemName, TotalIssuance, Used, ForRepair, DamagedScrap, (Used + ForRepair + DamagedScrap) TotalReturns
			From (
				Select ItemName,
					SUM(Case When Category = 'Issuance' Then Quantity Else 0 End) TotalIssuance,
					SUM(Case When ItemStatus = 'Used' AND Category = 'Returns' Then Quantity Else 0 End) Used,
					SUM(Case When ItemStatus = 'For Repair' AND Category = 'Returns' Then Quantity Else 0 End) ForRepair,
					SUM(Case When ItemStatus = 'Damaged/Scrap' AND Category = 'Returns' Then Quantity Else 0 End) DamagedScrap
				From IrrigItemNames Where ID IN (
					Select PK From IrrigDocument Where Assignee IN (
						Select Name From tblULFS Where FarmerNo IN (
							Select FarmerNo From consIrrigAuthorizedRep Where FarmerNo = '%{$FarmNumber}%'
							Group By FarmerNo
						)
					)
				)
				Group By ItemName
			) A
		) total ON items.ItemNames = total.ItemName
		Where Phase !='' AND Phase = 'PHASE 2' AND Assembly = 'DISTRIBUTION NETWORK'
		Union
		Select 4 sort, '' Phase, 'INFIELD CONTROL' Assembly, '' ItemNames, '' Unit, '' Classification, 0 TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '0%' Returns
		Union
		Select 4 sort, Phase, Assembly, ItemNames, Unit, 'CAPEX' Classification,
			   ISNULL(TotalIssuance,0) TotalIssuance,
			   ISNULL(Used, 0) Used,
			   ISNULL(ForRepair, 0) ForRepair,
			   ISNULL(DamagedScrap, 0) DamagedScrap,
			   ISNULL(TotalIssuance - TotalReturns, 0) Total,
			   ISNULL(TotalReturns,0) TotalReturns,
			   CONVERT(varchar,ROUND(ISNULL(Case When TotalReturns <= 0 Then 0 Else TotalIssuance/TotalReturns End, 0), 2))+'%' Returns
		From consIrrigItems Items
		Left Join (
			Select ItemName, TotalIssuance, Used, ForRepair, DamagedScrap, (Used + ForRepair + DamagedScrap) TotalReturns
			From (
				Select ItemName,
					SUM(Case When Category = 'Issuance' Then Quantity Else 0 End) TotalIssuance,
					SUM(Case When ItemStatus = 'Used' AND Category = 'Returns' Then Quantity Else 0 End) Used,
					SUM(Case When ItemStatus = 'For Repair' AND Category = 'Returns' Then Quantity Else 0 End) ForRepair,
					SUM(Case When ItemStatus = 'Damaged/Scrap' AND Category = 'Returns' Then Quantity Else 0 End) DamagedScrap
				From IrrigItemNames Where ID IN (
					Select PK From IrrigDocument Where Assignee IN (
						Select Name From tblULFS Where FarmerNo IN (
							Select FarmerNo From consIrrigAuthorizedRep Where FarmerNo = '%{$FarmNumber}%'
							Group By FarmerNo
						)
					)
				)
				Group By ItemName
			) A
		) total ON items.ItemNames = total.ItemName
		Where Phase !='' AND Phase = 'PHASE 2' AND Assembly = 'INFIELD CONTROL'
	) B
	Union
	Select 3 Sort, 'PHASE 3' Phase, '' Assembly, '' ItemNames, '' Unit, '' Classification, '' TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '%' Returns
	Union
		Select 3 Sort, * From (
		Select '' Phase, 'LATERAL NETWORK' Assembly, '' ItemNames, '' Unit, '' Classification, 0 TotalIssuance, 0 Used, 0 ForRepair, 0 DamagedScrap, 0 Total, 0 TotalReturns, '0%' Returns
		Union
		Select Phase, Assembly, ItemNames, Unit, 'CAPEX' Classification,
			   ISNULL(TotalIssuance,0) TotalIssuance,
			   ISNULL(Used, 0) Used,
			   ISNULL(ForRepair, 0) ForRepair,
			   ISNULL(DamagedScrap, 0) DamagedScrap,
			   ISNULL(TotalIssuance - TotalReturns, 0) Total,
			   ISNULL(TotalReturns,0) TotalReturns,
			   CONVERT(varchar,ROUND(ISNULL(Case When TotalReturns <= 0 Then 0 Else TotalIssuance/TotalReturns End, 0), 2))+'%' Returns
		From consIrrigItems Items
		Left Join (
			Select ItemName, TotalIssuance, Used, ForRepair, DamagedScrap, (Used + ForRepair + DamagedScrap) TotalReturns
			From (
				Select ItemName,
					SUM(Case When Category = 'Issuance' Then Quantity Else 0 End) TotalIssuance,
					SUM(Case When ItemStatus = 'Used' AND Category = 'Returns' Then Quantity Else 0 End) Used,
					SUM(Case When ItemStatus = 'For Repair' AND Category = 'Returns' Then Quantity Else 0 End) ForRepair,
					SUM(Case When ItemStatus = 'Damaged/Scrap' AND Category = 'Returns' Then Quantity Else 0 End) DamagedScrap
				From IrrigItemNames Where ID IN (
					Select PK From IrrigDocument Where Assignee IN (
						Select Name From tblULFS Where FarmerNo IN (
							Select FarmerNo From consIrrigAuthorizedRep Where FarmerNo = '%{$FarmNumber}%'
							Group By FarmerNo
						)
					)
				)
				Group By ItemName
			) A
		) total ON items.ItemNames = total.ItemName
		Where Phase !='' AND Phase = 'PHASE 3' AND Assembly = 'LATERAL NETWORK'
	) B
) B
";

$data = Dynaset::load($sql);

while($row = mssql_fetch_assoc($data)){
    if($row['Phase'] == "PHASE 1" && $row['Assembly'] == ""){
    
?>
    <tr>
        <td>PHASE 1</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <?php } else if ($row['Phase'] == "PHASE 1" && $row['Returns'] != '') {?>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo $row['Assembly']; ?></td>
        <td><?php echo $row['ItemNames']; ?></td>
        <td><?php echo $row['Unit']; ?></td>
        <td><?php echo $row['Classification']; ?></td>
        <td><?php echo $row['TotalIssuance']; ?></td>
        <td><?php echo $row['Used']; ?></td>
        <td><?php echo $row['ForRepair']; ?></td>
        <td><?php echo $row['DamagedScrap']; ?></td>
        <td><?php echo $row['Total']; ?></td>
        <td><?php echo $row['TotalReturns']; ?></td>
        <td><?php echo $row['Returns']; ?></td>
    </tr>
    <?php } ?>
<?php } ?>