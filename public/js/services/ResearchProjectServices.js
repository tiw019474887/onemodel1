/**
 * Created by chaow on 11/28/2014 AD.
 */

angular.module('ResearchProjectServices',[])
    .factory('ResearchProject',function($http){
        return {
            get : function(){
                return $http.get('/api/research-projects');
            },
            view : function($id){
                return $http.get('/api/research-projects/view/' + $id);
            },
            viewPhoto : function($id,$skip){
                return $http.get('/api/research-projects/view-photo/'+$id+'/'+$skip);
            },
            save : function(researchProject){
                return $http({
                    url : '/api/research-projects/save',
                    method: 'POST',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(researchProject)
                });
            },
            delete : function(researchProject){
                return $http({
                    method: 'POST',
                    url: '/api/research-projects/delete',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(researchProject)
                });
            },
            uploadImage : function(id,image){
                return $http({
                    url : '/api/research-projects/upload-image/'+id,
                    method : 'POST',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(image)
                })
            }
        }
    });