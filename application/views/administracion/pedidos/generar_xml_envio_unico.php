<?php header ("Content-Type:text/xml"); ?>
<?xml version="1.0" encoding="UTF-8"?>
<req:ShipmentRequest xmlns:req="http://www.dhl.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com ship-val-global-req.xsd" schemaVersion="4.0">
	<Request>
		<ServiceHeader>
			<MessageTime><?php echo date('c'); ?></MessageTime>
			<MessageReference><?php echo date("YmdHis").str_pad($pedido->id_pedido, 16, '0', STR_PAD_LEFT); ?></MessageReference>
			<SiteID>DHLMexico</SiteID>
			<Password>hUv5E3nMjQz6</Password>
		</ServiceHeader>
	</Request>
	<RegionCode>AM</RegionCode>
	<RequestedPickupTime>Y</RequestedPickupTime>
	<NewShipper>Y</NewShipper>
	<LanguageCode>en</LanguageCode>
	<PiecesEnabled>Y</PiecesEnabled>
	<Billing>
		<ShipperAccountNumber>980009077</ShipperAccountNumber>
		<ShippingPaymentType>S</ShippingPaymentType>
		<BillingAccountNumber>980009077</BillingAccountNumber>
	</Billing>
	<Consignee>
		<CompanyName><?php echo strtoupper(convert_accented_characters($cliente->nombres.' '.$cliente->apellidos)); ?></CompanyName>
		<AddressLine><?php echo strtoupper(convert_accented_characters($direccion->linea1)); ?></AddressLine>
		<AddressLine><?php echo strtoupper(convert_accented_characters($direccion->linea2)); ?></AddressLine>		 
		<AddressLine><?php echo strtoupper(convert_accented_characters($direccion->ciudad)); ?></AddressLine>
		<City><?php echo strtoupper(convert_accented_characters($direccion->ciudad)); ?></City>
		<PostalCode><?php echo $direccion->codigo_postal; ?></PostalCode>
		<CountryCode>MX</CountryCode>
		<CountryName>MEXICO</CountryName>
		<Contact>
			<PersonName><?php echo strtoupper(convert_accented_characters($cliente->nombres.' '.$cliente->apellidos)); ?></PersonName>
			<PhoneNumber><?php echo $direccion->telefono; ?></PhoneNumber>
			<Email><?php echo $cliente->email; ?></Email>
		</Contact>
	</Consignee>
	<ShipmentDetails>
		<NumberOfPieces>1</NumberOfPieces>
		<Pieces>
			<Piece>
				<PieceID>1</PieceID>
				<PackageType>EE</PackageType>
				<Weight>2.0</Weight>
			</Piece>
		</Pieces>
		<Weight>2.0</Weight>
		<WeightUnit>K</WeightUnit>
		<GlobalProductCode>N</GlobalProductCode>
		<LocalProductCode>N</LocalProductCode>
		<Date><?php echo date("Y-m-d"); ?></Date>
		<Contents>DOCUMENTO NACIONAL</Contents>
		<DoorTo>DD</DoorTo>
		<DimensionUnit>C</DimensionUnit>
		<InsuredAmount>0</InsuredAmount>
		<PackageType>EE</PackageType>
		<IsDutiable>N</IsDutiable>
		<CurrencyCode>MXN</CurrencyCode>
	</ShipmentDetails>
	<Shipper>
		<ShipperID>980009077</ShipperID>
		<CompanyName>PRINTOME</CompanyName>
		<RegisteredAccount>980009077</RegisteredAccount>
		<AddressLine>CALLE 133-A NO EXT 815 INT 55</AddressLine>
		<AddressLine>CRUZAMIENTOS 46-A Y 46-I</AddressLine>
		<AddressLine>FRACC. VILLA MAGNA DEL SUR</AddressLine>
		<City>MERIDA</City>
		<Division>MERIDA</Division>
		<PostalCode>97285</PostalCode>
		<CountryCode>MX</CountryCode>
		<CountryName>MEXICO</CountryName>
		<Contact>
			<PersonName>GABRIELA CRUZ HERNANDEZ</PersonName>
			<PhoneNumber>9992595995</PhoneNumber>
			<Email>administracion@printome.mx</Email>
		</Contact>
	</Shipper>
	<EProcShip>N</EProcShip>
	<LabelImageFormat>PDF</LabelImageFormat> 
</req:ShipmentRequest>
