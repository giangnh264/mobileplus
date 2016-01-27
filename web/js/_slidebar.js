(function($, undefined) {
	SlideBar = function(cid, pid, pageSize, pageCount) {
		var self = this;
		this.cid = cid;
		this.pid = pid;
		this.pageSize = pageSize;
		this.pageCount = pageCount;
		this.currentPage = 0;

        var i;
        for(i=this.pageCount;i<3;i++){
            $("#"+this.pid+i).hide();
        }
        if (this.pageCount <= 0){
            $("#"+this.pid+'Next').hide();
            $("#"+this.pid+'Prev').hide();
        }
	}

	SlideBar.prototype = {
		    moveNext: function (){
		        if (this.currentPage<this.pageCount-1){
		            this.currentPage++;
		            this.moveToPage(this.cid,this.currentPage,this.pageSize,this.pageCount);
		            /*this.setCurrentPage();*/
		        }
		    },

		    movePrev: function(){
		        if (this.currentPage>0){
		            this.currentPage--;
		            this.moveToPage(this.cid,this.currentPage,this.pageSize,this.pageCount);
		            /*this.setCurrentPage();*/
		        }
		    },

		    goPage: function (page){
		        if (page >=0 && page<=this.pageCount && page != this.currentPage){
		            this.currentPage = page;
		            this.moveToPage(this.cid,this.currentPage,this.pageSize,this.pageCount);
		            /*this.setCurrentPage();*/
		        }
		    },

		    setCurrentPage:	function(){
		        var i=0;
		        for (i=0;i<this.pageCount;i++){
		        	el = document.getElementById(this.pid+i);
		            el.className = '';
		            if(this.pid+i == this.pid+this.currentPage ){
		            	el.className = 'selected';
		            }
		        }
		    },



		    moveToPage: function(cid,page,pageSize,pageCount){
		        if (page >= 0 && page <= pageCount){
		            var left = $("."+this.pid).eq(page-1).position().left;
		            $("#"+cid).animate({"left":"-"+left+"px"});
		            $("#"+cid).attr("class","page_"+page);
		        }
		    }
	}
})(jQuery);