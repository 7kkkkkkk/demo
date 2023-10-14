<!-- 
    Card style
        1. 用户人数
        2. 今日回复数量
        3. 今日发帖数量
        4. 今日活跃用户

    Chart style
        1. 饼状图 - 各个course的人数
        2. Stacked Horizontal Bar - 每日course发帖数量
        3. 折线图 - 论坛活跃度
            Here's an example calculation:

            Given:
            - Number of new posts: 4
            - Number of new comments: 5
            - Number of unique users: 3

            Weights:
            - Weight for posts: 2
            - Weight for comments: 1
            - Weight for unique users: 3

            Calculation:
            Weighted score for posts = Number of posts * Weight for posts = 4 * 2 = 8
            Weighted score for comments = Number of comments * Weight for comments = 5 * 1 = 5
            Weighted score for unique users = Number of unique users * Weight for unique users = 3 * 3 = 9

            Activity Index = Weighted score for posts + Weighted score for comments + Weighted score for unique users = 8 + 5 + 9 = 22
        4. dataset（双柱状图） - 今日被回复了的帖子/今日没被回复的帖子

 -->
<!-- <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script> -->
<body>
  <!-- Prepare a DOM with a defined width and height for ECharts -->
    <div class="container">
        <div class="row mt-5">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div id="pie-chart" style="width: 600px;height:400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div id="stack-bar" style="width: 600px;height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('node_modules/echarts/dist/echarts.min.js') ?>"></script>
    <script type="text/javascript">
        var pieChart = echarts.init(document.getElementById('pie-chart'));
        var stackBar = echarts.init(document.getElementById('stack-bar'));
        var courseCodes = ['COMP3200', 'INFS7200', 'MATH2101', 'CSE101'];
        var enrollmentData = [
            <?php foreach ($enrollmentData as $dataItem): ?>
                { value: <?= $dataItem->enrollment_count ?>, name: '<?= $dataItem->course_code ?>' },
            <?php endforeach; ?>
        ];
        pieChart.setOption({
            title: {
                text: 'Students number by courses',
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            legend: {
                orient: 'vertical',
                left: 'left'
            },
            series: [
                {
                name: 'Access From',
                type: 'pie',
                radius: '50%',
                data: enrollmentData,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
                }
            ]
        });
    var d = <?= json_encode($postsByCourse) ?>;
    console.log(d);
    stackBar.setOption({
        title: {
            text: 'Number of posts per course per day',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
            // Use axis to trigger tooltip
            type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
            }
        },
        legend: {                
            orient: 'vertical',
            left: 'right'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '1%',
            containLabel: true
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: ['May 15th', 'May 16th', 'May 17th', 'May 18th', 'May 19th']
        },
        series: [
            <?php foreach ($postsByCourse as $item): ?>
            {
                name: '<?= $item['course_code'] ?>',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true
                },
                emphasis: {
                    focus: 'series'
                },
                data: <?= json_encode($item['post_count']) ?>
            },
            <?php endforeach; ?>
        ]
    });
    
    </script>
</body>