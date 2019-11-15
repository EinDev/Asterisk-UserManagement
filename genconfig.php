<config xmlns="http://www.linphone.org/xsds/lpconfig.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.linphone.org/xsds/lpconfig.xsd lpconfig.xsd">
    <section name="sip">
        <entry name="use_info" overwrite="true">0</entry>
        <entry name="register_only_when_network_is_up" overwrite="true">1</entry>
        <entry name="media_encryption" overwrite="true">srtp</entry>
        <entry name="default_proxy" overwrite="true">0</entry>
        <entry name="sip_tcp_port">5070</entry>
        <entry name="dscp">0x0</entry>
        <entry name="ping_with_options">0</entry>
        <entry name="contact=">sip:<?php echo $_GET['username']; ?>@192.168.188.22:5060</entry>
    </section>
    <section name="proxy_0">
        <entry name="reg_proxy" overwrite="true">192.168.188.23;transport=tcp</entry>
        <entry name="reg_identity" overwrite="true">sip:<?php echo $_GET['username']; ?>@192.168.188.23</entry>
        <entry name="reg_expires" overwrite="true">3600</entry>
        <entry name="reg_sendregister" overwrite="true">1</entry>
        <entry name="publish" overwrite="true">0</entry>
        <entry name="dial_escape_plus" overwrite="true">1</entry>
        <entry name="push_notification_allowed" overwrite="true">1</entry>
    </section>
    <section name="auth_info_0">
        <entry name="username" overwrite="true"><?php echo $_GET['username']; ?></entry>
        <entry name="userid" overwrite="true"><?php echo $_GET['username']; ?></entry>
        <entry name="ha1" overwrite="true"><?php echo $_GET['pass']; ?></entry>
        <entry name="domain" overwrite="true">192.168.188.23</entry>
        <entry name="realm" overwrite="true">asterisk</entry>
    </section>
    <section name="audio_codec_0">
        <entry name="mime" overwrite="true">PCMU</entry>
        <entry name="rate" overwrite="true">8000</entry>
        <entry name="channels" overwrite="true">1</entry>
        <entry name="enabled" overwrite="true">1</entry>
    </section>
    <section name="audio_codec_1">
        <entry name="mime" overwrite="true">G722</entry>
        <entry name="rate" overwrite="true">8000</entry>
        <entry name="channels" overwrite="true">1</entry>
        <entry name="enabled" overwrite="true">1</entry>
    </section>
</config>