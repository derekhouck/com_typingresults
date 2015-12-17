<?php
/** 
* @package     Type Me, Please 
* @subpackage  com_typingresults
* 
* @copyright   Copyright (C) 2015 Section Thirteen. All rights reserved. 
*/ 
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$doc = JFactory::getDocument();
$doc->addScript('media/com_typingresults/js/d3.layout.cloud.js');
?>
<article>
	<h2>Typing Results for</h2>
	<div id="headshotInfo">
		<div>
			<h3><?php echo $this->currentActor; ?></h3>
			<h4><?php echo $this->headshotName; ?></h4>
		</div>
		<img src="<?php echo $this->headshotImage; ?>" alt="<?php echo $this->headshotName; ?>" />
	</div>
	<div id="typingResults">
		<div id="ageRange" class="chart">
			<h3>Age Range</h3>
			<div id="ageMinContainer">
				<h4>As Young As</h4>
				<?php print_r $this->ageMin; ?>
				<svg id="chart_ageMin" class="chart_bar"></svg>
			</div>
			<div id="ageMaxContainer">
				<h4>As Old As</h4>
				<svg id="chart_ageMax" class="chart_bar"></svg>
			</div>
		</div>
		<div id="chart_orientation" class="chart">
			<h3>Orientation</h3>
		</div>
		<div id="chart_lookLike" class="chart">
			<h3>Do they look like this headshot?</h3>
		</div>
		<div id="chart_ethnicity" class="chart">
			<h3>Ethnicity</h3>
		</div>
		<div id="chart_occupation" class="chart">
			<h3>Occupation</h3>
		</div>
		<div id="chart_personality" class="chart">
			<h3>Personality</h3>
		</div>
		<div id="chart_archetype" class="chart">
			<h3>Archetype</h3>
		</div>
	</div>
</article>
<script type="text/javascript">
	// Pie charts
	var colorRange = ['#c1272d', '#811A1E', '#400D0F', '#D66F73'];
	var orientationRows = <?php echo $this->orientation; ?>;
 	var lookLikeRows = <?php echo $this->lookLikeHeadshot; ?>;
	var oreintationPie = new d3pie("chart_orientation", {
		"size": {
			"canvasHeight": 250,
			"canvasWidth": 250,
			"pieOuterRadius": "100%"
		},
		"data": {
			"content": orientationRows
		},
		"labels": {
			"outer": {
				"format": "none"
			},
			"inner": {
				"format": "label-percentage2",
				"hideWhenLessThanPercentage": 1
			},
			"mainLabel": {
				"color": "#e1e1e1",
				"font": "verdana",
				"fontSize": 12
			},
			"percentage": {
				"color": "#e1e1e1",
				"font": "verdana",
				"decimalPlaces": 0
			},
			"truncation": {
				"enabled": true
			}
		},
		"tooltips": {
			"enabled": true,
			"type": "placeholder",
			"string": "{label}: {value}"
		},
		"misc": {
			"colors": {
				"segments" : colorRange
			}
		}
	});
	var lookLikePie = new d3pie("chart_lookLike", {
		"size": {
			"canvasHeight": 250,
			"canvasWidth": 250,
			"pieOuterRadius": "100%"
		},
		"data": {
			"content": lookLikeRows
		},
		"labels": {
			"outer": {
				"format": "none"
			},
			"inner": {
				"format": "label-percentage2",
				"hideWhenLessThanPercentage": 1
			},
			"mainLabel": {
				"color": "#e1e1e1",
				"font": "verdana",
				"fontSize": 12
			},
			"percentage": {
				"color": "#e1e1e1",
				"font": "verdana",
				"decimalPlaces": 0
			},
			"truncation": {
				"enabled": true
			}
		},
		"tooltips": {
			"enabled": true,
			"type": "placeholder",
			"string": "{label}: {value}"
		},
		"misc": {
			"colors": {
				"segments" : colorRange
			}
		}
	});
</script>
<script type="text/javascript">
	//Bar charts
	  var ageMinRows = <?php echo $this->ageMin; ?>;
	  var ageMaxRows = <?php echo $this->ageMax; ?>;
      function barChart (fieldname, chartContainer) {
      	this.data = fieldname;
      	this.chart = chartContainer;
		var margin = {top: 20, right: 30, bottom: 30, left: 40},
			width = 350 - margin.left - margin.right,
			height = 200 - margin.top - margin.bottom;
		var x = d3.scale.ordinal()
			.domain(this.data.map(function(d) { return d.label; }))
			.rangeRoundBands([0, width], .1);
		var y = d3.scale.linear()
			.domain([0, d3.max(this.data, function(d) { return d.value; })])
			.range([height, 0]);
		var xAxis = d3.svg.axis()
			.scale(x)
			.orient("bottom");
		var yAxis = d3.svg.axis()
			.scale(y)
			.orient("left");
		var chart = d3.select(this.chart)
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
		  .append("g")
		  	.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		chart.append("g")
			.attr("class", "x axis")
			.attr("transform", "translate(0," + height + ")")
			.call(xAxis);
		chart.append("g")
			.attr("class", "y axis")
			.call(yAxis)
		  .append("text")
		  	.attr("transform", "rotate(-90)")
		  	.attr("y", 6)
		  	.attr("dy", ".71em")
		  	.style("text-anchor", "end")
		  	.text("Frequency");
		chart.selectAll(".bar")
			.data(this.data)
		  .enter().append("rect")
		  	.attr("class", "bar")
		  	.attr("x", function(d) { return x(d.label); })
			.attr("y", function(d) { return y(d.value); })
			.attr("height", function(d) { return height - y(d.value); })
			.attr("width", x.rangeBand());
      }
      var ageMinChart = new barChart(ageMinRows, "#chart_ageMin");
      var ageMaxChart = new barChart(ageMaxRows, "#chart_ageMax");
</script>
<script type="text/javascript">
	// Word Clouds
	var ethnicityData = <?php echo $this->ethnicity ?>;
	var occupationData = <?php echo $this->occupation ?>;
	var personalityData = <?php echo $this->personality ?>;
	var archetypeData = <?php echo $this->archetype ?>;
	function wordCloud(data, chartContainer) {
		this.data = data;
		this.chartContainer = chartContainer;

		var tooltip = d3.select("body")
			.append("div")
			.attr("class", "wordcloud tooltip")
			.style("position", "absolute")
			.style("z-index", "10")
			.style("visibility", "hidden");
		var color = d3.scale.linear()
				.domain([0,1,2,3,4,5,6,10,15,20,100])
				.range(['#200708', '#400D0F', '#611417', '#811A1E', '#A12126', '#C1272D', '#CB4B50', '#D66F73', '#E09396', '#EAB7B9', '#F5DBDC']);
		var layout = d3.layout.cloud()
				.size([350, 250])
				.words(this.data)
				.padding(2)
				.rotate(0)
				.fontSize(function(d) { return d.size; })
				.spiral("rectangular")
				.on("end", draw);
		var svg = d3.select(this.chartContainer).append("svg")
					.attr("width", layout.size()[0])
					.attr("height", layout.size()[1])
					.attr("class", "wordcloud")
				.append("g")
					.attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")");
		layout.start();

		function draw(words) {
				svg.selectAll("text")
					.data(words)
				.enter().append("text")
					.style("font-size", function(d) { return d.size + "px"; })
					.style("fill", function(d, i) { return color(i); })
					.attr("text-anchor", "middle")
					.attr("transform", function(d) {
						return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
					})
					.text(function(d) { return d.text; })
					.on("mouseover", function(){return tooltip.style("visibility", "visible");})
					.on("mousemove", function(d){
						d3.select(this)
						tooltip.style("top", function() { return (d3.event.pageY-10)+"px"; })
							   .style("left",function() { return (d3.event.pageX+10)+"px"; })
							   .text( d.text + ": " + d.value );
					})
					.on("mouseout", function(){return tooltip.style("visibility", "hidden");});
		}
	}
	var ethnicityChart = new wordCloud(ethnicityData, "#chart_ethnicity");
	var occupationChart = new wordCloud(occupationData, "#chart_occupation");
	var personalityChart = new wordCloud(personalityData, "#chart_personality");
	var archetypeChart = new wordCloud(archetypeData, "#chart_archetype");
</script>