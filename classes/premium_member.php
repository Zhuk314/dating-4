<?php

class PremiumMember extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;

    /**
     * PremiumMember constructor.
     * @param string $_fname
     * @param string $_lname
     * @param string $_age
     * @param string $_gender
     * @param string $_phone
     * @param string $_email
     * @param string $_state
     * @param string $_seeking
     * @param string $_bio
     * @param array $_inDoorInterests
     * @param array $_outDoorInterests
     */
    public function __construct($_fname="", $_lname="", $_age="0",
                                $_gender="", $_phone="", $_email="",
                                $_state="", $_seeking="", $_bio="",
                                $_inDoorInterests=array(),
                                $_outDoorInterests=array())
    {
        parent::__construct($_fname, $_lname, $_age, $_gender, $_phone,
            $_email, $_state, $_seeking, $_bio);
        $this->_inDoorInterests = $_inDoorInterests;
        $this->_outDoorInterests = $_outDoorInterests;
    }

    /**
     * @return array
     */
    public function getInDoorInterests(): array
    {
        return $this->_inDoorInterests;
    }

    /**
     * @param array $inDoorInterests
     */
    public function setInDoorInterests(array $inDoorInterests): void
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @return array
     */
    public function getOutDoorInterests(): array
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param array $outDoorInterests
     */
    public function setOutDoorInterests(array $outDoorInterests): void
    {
        $this->_outDoorInterests = $outDoorInterests;
    }


}