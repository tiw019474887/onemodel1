/**
 * Created by chaow on 12/2/2014 AD.
 */

angular.module('FacultyServices',[])
    .factory('Faculty',function($http){
        return {
            get: function () {
                return $http.get('/api/faculties');
            },
            save: function (faculty) {
                return $http({
                    url: '/api/faculties/save',
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(faculty)
                });
            },
            delete: function (faculty) {
                return $http({
                    method: 'POST',
                    url: '/api/faculties/delete',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param(faculty)
                });
            }
        }

    });