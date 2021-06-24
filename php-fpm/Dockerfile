#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#
# To edit the 'php-fpm' base Image, visit its repository on Github
#    https://github.com/Laradock/php-fpm
#
# To change its version, see the available Tags on the Docker Hub:
#    https://hub.docker.com/r/laradock/php-fpm/tags/
#
# Note: Base Image name format {image-tag}-{php-version}
#


FROM laradock/php-fpm:2.7-7.3

LABEL maintainer="Elvis Reyes <teclaelvis01@gmail.com>"

ARG PHP_VERSION=7.3

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive


# always run apt update when start and after add new source list, then clean up at end.
RUN set -xe; \
    apt-get update -yqq && \
    pecl channel-update pecl.php.net && \
    apt-get install -yqq \
      apt-utils \
      #
      #--------------------------------------------------------------------------
      # Mandatory Software's Installation
      #--------------------------------------------------------------------------
      #
      # Mandatory Software's such as ("mcrypt", "pdo_mysql", "libssl-dev", ....)
      # are installed on the base image 'laradock/php-fpm' image. If you want
      # to add more Software's or remove existing one, you need to edit the
      # base image (https://github.com/Laradock/php-fpm).
      #
      # next lines are here becase there is no auto build on dockerhub see https://github.com/laradock/laradock/pull/1903#issuecomment-463142846
      libzip-dev zip unzip && \
      docker-php-ext-configure zip --with-libzip; \
      # Install the zip extension
      docker-php-ext-install zip && \
      php -m | grep -q 'zip'


###########################################################################
# GMP (GNU Multiple Precision):
###########################################################################

ARG INSTALL_GMP=false

RUN if [ ${INSTALL_GMP} = true ]; then \
    # Install the GMP extension
	  apt-get install -y libgmp-dev && \
    if [ $(php -r "echo PHP_MAJOR_VERSION;") = "5" ]; then \
      ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h \
    ;fi && \
    docker-php-ext-install gmp \
;fi

# ###########################################################################
# # Imagick:
# ###########################################################################

# RUN apt-get install -y libmagickwand-dev imagemagick && \
#     pecl install imagick && \
#     docker-php-ext-enable imagick \


###########################################################################
# Exif:
###########################################################################


RUN docker-php-ext-install exif 

###########################################################################
# Mysqli Modifications:
###########################################################################
RUN docker-php-ext-install mysqli 



###########################################################################
# Phalcon:
###########################################################################

# Copy phalcon configration
COPY ./phalcon.ini /usr/local/etc/php/conf.d/phalcon.ini.disable




RUN apt-get update && apt-get install -yqq unzip libpcre3-dev gcc make re2c git automake autoconf \
    && git clone https://github.com/jbboehr/php-psr.git \
    && cd php-psr \
    && phpize \
    && ./configure \
    && make \
    && make test \
    && make install \
    && curl -L -o /tmp/cphalcon.zip https://github.com/phalcon/cphalcon/archive/v4.0.6.zip \
    && unzip -d /tmp/ /tmp/cphalcon.zip \
    && cd /tmp/cphalcon-4.0.6/build \
    && ./install \
    && mv /usr/local/etc/php/conf.d/phalcon.ini.disable /usr/local/etc/php/conf.d/phalcon.ini \
    && rm -rf /tmp/cphalcon*


###########################################################################
# Check PHP version:
###########################################################################

RUN set -xe; php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."


#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

COPY ./phprules.ini /usr/local/etc/php/conf.d
COPY ./x.pool.conf /usr/local/etc/php-fpm.d/

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Configure non-root user.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data


# Configure locale.
ARG LOCALE=POSIX
ENV LC_ALL ${LOCALE}

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
