<form id="pagerForm" method="post" action="/manage/user/index">
    <input type="hidden" name="username" value="<?php echo isset($request['username']) ? $request['username'] : ''; ?>" />
    <input type="hidden" name="pageNum" value="<?php echo isset($request['pageNum']) ? $request['pageNum'] : 1 ; ?>" />
    <input type="hidden" name="numPerPage" value="<?php echo isset($request['numPerPage']) ? $request['numPerPage'] : 20 ; ?>" />
    <input type="hidden" name="orderField" value="<?php echo isset($request['orderField']) ? $request['orderField'] : 'id'; ?>" />
    <input type="hidden" name="orderDirection" value="<?php echo isset($request['orderDirection']) ? $request['orderDirection'] : 'desc'; ?>" />
</form>

<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="/manage/user/index" method="post">
    <div class="searchBar">
        <table class="searchContent">
            <tr>
                <td>
                    用户名：<input type="text" name="username" value="<?php echo isset($request['username']) ? $request['username'] : ''; ?>" />
                </td>
            </tr>
        </table>
        <div class="subBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                <li><a class="button" href="/manage/User" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
            </ul>
        </div>
    </div>
    </form>
</div>

<div class="pageContent">
    <table class="table" width="100%" layoutH="110">
        <thead>
        <tr>
            <th width="30" orderField="id"
                <?php if(isset($request['orderDirection'])){echo 'orderDirection="'.$request['orderDirection'].'"';} ?>
                <?php if(isset($request['orderDirection'])){echo 'class="'.$request['orderDirection'].'"';} ?>
                >ID</th>
            <th width="80">用户名</th>
            <th width="100">email</th>
            <th width="80">手机号</th>
            <th width="20">状态</th>
            <th width="100">注册时间</th>
            <th width="100">最后登录时间</th>
        </tr>
        </thead>
        <tbody>
            <?php if($list): ?>
            <?php foreach($list as $row): ?>
                <tr target="sid_user" rel="<?php echo $row->id; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->username; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->mobile; ?></td>
                    <td><?php echo $row->islock == 1 ? '启用' : '禁用'; ?></td>
                    <td><?php echo $row->regtime ? date('Y-m-d H:i:s',$row->regtime) : '-'; ?></td>
                    <td><?php echo $row->lastlogin ? date('Y-m-d H:i:s',$row->lastlogin) : '-'; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages">
            <span>显示</span>
            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
            <span>条，共<?php echo $count; ?>条</span>
        </div>

        <div class="pagination" targetType="navTab" totalCount="<?php echo $count; ?>" numPerPage="<?php echo isset($request['numPerPage']) ? $request['numPerPage'] : 20 ; ?>" pageNumShown="10" currentPage="<?php echo isset($request['pageNum']) ? $request['pageNum'] : 1 ; ?>"></div>

    </div>
</div>
