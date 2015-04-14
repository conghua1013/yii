<h2 class="contentTitle">商品属性树形图【<a class="add" href="manage/product/productAttrAdd" target="navTab" title="商品属性添加"><span>商品属性添加</span></a>】</h2>
<div id="resultBox"></div>

<div style="float:left; display:block; margin:10px; overflow:auto; width:800px; height:600px; border:solid 1px #CCC; line-height:21px; background:#FFF;">
    <ul class="tree treeFolder treeCheck expand ">     <!--collapse-->
        <?php if($tree): ?>
            <?php foreach($tree as $list): ?>
                <li><a tname="name" tvalue="<?php echo $list['id']; ?>"><?php echo $list['attr_name']; ?></a>

                    <?php if(isset($list['child']) && !empty($list['child'])): ?>
                        <?php foreach($list['child'] as $row): ?>
                            <ul>
                                <li><a tname="name" tvalue="<?php echo $row['id']; ?>"> <?php echo $row['attr_name']; ?> </a></li>
                            </ul>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<script type="text/javascript">
    function kkk(){
        var json = arguments[0], result="";
        // alert(json.checked);
        $(json.items).each(function(i){
            result += "<p>name:"+this.name + " value:"+this.value+" text: "+this.text+"</p>";
        });
        $("#resultBox").html(result);
    }
</script>
