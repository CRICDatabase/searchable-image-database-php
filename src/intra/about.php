<h2>About</h2>
<p>CRIC Searchable Image Database is one of the “products” from a multidisciplinary team of researchers from computer science and biology.</p>

<p>The Database is a collection of real images from human cervix representing a range of different lesions in cervical cells interpreted by independent pathologists. The database will be able to provide information about individual cell segmentation, classification or both.</p>

<p>The database is also a dynamic environment since it has web applications for hand label segmentation and classification from specialists. The application permits upload images, segment, classify and save information, keeping the database in movement.
Guest area will provide free access to particular image segmentation and classification database available.</p>

<h2>Cervical Cell Information</h2>

<p>The images were obtained using a xx microscopy under xx of 40x.</p>


<div class="chart" id="basic-example"></div>

<script type="text/javascript">
	
var simple_chart_config = {
	chart: {
		container: "#basic-example"
	},
	
	nodeStructure: {
		text: { name: "Types" },
		children: [
			{
				text: { name: "Ephitelium" },
				children:[
					{
						text: { name: "Scamous epithelium" },
						children:[
							{
								text: { name: "Imature" },
								children:[
									{
										text: { name: "Basal" },
										children:[
											{
												text: { name: "Normal" }
											},
											{
												text: { name: "Lesion" },
												children:[
													{
														text: { name: "ASC-H" }
													},
													{
														text: { name: "HSIL" }
													},
													{
														text: { name: "Carcinoma" }
													}
												]
											}
										]
									},
									{
										text: { name: "Parabasal" },
										children:[
											{
												text: { name: "Normal" }
											},
											{
												text: { name: "Lesion" },
												children:[
													{
														text: { name: "ASC-H" }
													},
													{
														text: { name: "HSIL" }
													},
													{
														text: { name: "Carcinoma" }
													}
												]
											}
										]
									}
								]
							},
							{
								text: { name: "Mature" },
								children:[
									{
										text: { name: "Superficial" },
										children:[
											{
												text: { name: "Normal" }
											},
											{
												text: { name: "Lesion" },
												children:[
													{
														text: { name: "ASC-US" }
													},
													{
														text: { name: "LSIL" }
													}
												]
											}
										]
									},
									{
										text: { name: "intermediate" },
										children:[
											{
												text: { name: "Normal" }
											},
											{
												text: { name: "Lesion" },
												children:[
													{
														text: { name: "ASC-US" }
													},
													{
														text: { name: "LSIL" }
													}
												]
											}
										]
									}
								]
							}
						]
					},
					{
						text: { name: "Metaplasic epithelium" },
						children:[
							{
								text: { name: "Imature" },
								children:[
									{
										text: { name: "Normal" }
									},
									{
										text: { name: "Lesion" },
										children:[
											{
												text: { name: "ASC-H" }
											},
											{
												text: { name: "HSIL" }
											},
											{
												text: { name: "Carcinoma" }
											}
										]
									}
								]
							},
							{
								text: { name: "Mature" },
								children:[
									{
										text: { name: "Normal" }
									},
									{
										text: { name: "Lesion" },
										children:[
											{
												text: { name: "ASC-US" }
											},
											{
												text: { name: "LSIL" }
											}
										]
									}
								]
							}
						]
					},
					{
						text: { name: "Glandular epithelium" },
						children:[
							{
								text: { name: "Endocervical" },
								children:[
									{
										text: { name: "Palisade" },
										children:[
											{
												text: { name: "Normal" }
											},
											{
												text: { name: "Lesion" },
												children:[
													{
														text: { name: "Endocervical" }
													},
													{
														text: { name: "Adenocarcinoma" }
													},
													{
														text: { name: "Adenocarcinoma Endocervical" }
													}													
												]
											}
										]
									},
									{
										text: { name: "Honeycomb" },
										children:[
											{
												text: { name: "Normal" }
											},
											{
												text: { name: "Lesion" },
												children:[
													{
														text: { name: "Endocervical" }
													},
													{
														text: { name: "Adenocarcinoma" }
													},
													{
														text: { name: "Adenocarcinoma Endocervical" }
													}													
												]
											}
										]
									},
									{
										text: { name: "Single" },
										children:[
											{
												text: { name: "Normal" }
											},
											{
												text: { name: "Lesion" },
												children:[
													{
														text: { name: "Endocervical" }
													},
													{
														text: { name: "Adenocarcinoma" }
													},
													{
														text: { name: "Adenocarcinoma Endocervical" }
													}													
												]
											}
										]
									}
								]
							},
							{
								text: { name: "Endometrial" },
								children:[
									{
										text: { name: "Normal" }
									},
									{
										text: { name: "Lesion" },
										children:[
											{
												text: { name: "Endocervical" }
											},
											{
												text: { name: "Adenocarcinoma" }
											}
										]
									}
								]
							}
						]
					}
				]
			},
			{
				text: { name: "Flora" },
				children: [
					{
						text: { name: "Leptotrix" },
						children:[
							{
							text: { name: "Bacilus" }
							}
						]
					},
					{
						text: { name: "Lactobacilus" }
					},
					{
						text: { name: "Cocos" }
					},
					{
						text: { name: "Trichomonas vaginalis" }
					},
					{
						text: { name: "Candida" }
					},
					{
						text: { name: "Actinomyces" }
					},
					{
						text: { name: "Bacterial vaginosis" }
					},
					{
						text: { name: "Clamídea" }
					},
					{
						text: { name: "Herpes" }
					},
					{
						text: { name: "CMV" }
					}
					
				]
			},
			{
				text: { name: "Others" },
				children:[
					{
						text: { name: "Neutrophil" }
					},
					{
						text: { name: "Erythrocyte" }
					},
					{
						text: { name: "Mucus" }
					},
					{
						text: { name: "Histiocite" }
					},
					{
						text: { name: "Lymphocyte" }
					},
					{
						text: { name: "Contaminant" }
					},
					{
						text: { name: "Artifact" }
					}
				]
			}
		]
	}
};


    




</script>

<script type="text/javascript">
	new Treant( simple_chart_config );
</script>
