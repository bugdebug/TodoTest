<?
/**
 * @method Posts_PostObject[] getAll
 * @method Posts_PostObject getById
 */
class Posts_PostMapper extends Data_Mapper {
    protected $table = "todo";
    protected $id = "id";
    protected $auto_increment = true;
    protected $object_class = "Posts_PostObject";
}